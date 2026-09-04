<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Process;
use Throwable;

class SystemUpdater
{
    public function isEnabled(): bool
    {
        return (bool) config('updater.enabled', true);
    }

    public function status(bool $fetchRemote = false): array
    {
        $remote = (string) config('updater.remote', 'origin');
        $branch = (string) config('updater.branch', 'main');
        $steps = [];

        if ($fetchRemote) {
            $steps[] = $this->runGit(['fetch', $remote, $branch, '--prune']);
        }

        $localCommit = $this->gitOutput(['rev-parse', 'HEAD']);
        $localShort = $this->gitOutput(['rev-parse', '--short', 'HEAD']);
        $localBranch = $this->gitOutput(['rev-parse', '--abbrev-ref', 'HEAD']);
        $localMessage = $this->gitOutput(['log', '-1', '--pretty=%s']);
        $localDate = $this->gitOutput(['log', '-1', '--pretty=%cI']);
        $dirtyFiles = $this->dirtyTrackedFiles();
        $dirty = $dirtyFiles !== [];

        $remoteRef = "{$remote}/{$branch}";
        $remoteCommit = $this->gitOutput(['rev-parse', $remoteRef]);
        $behind = null;
        $ahead = null;

        if ($localCommit !== '' && $remoteCommit !== '') {
            $behindRaw = $this->gitOutput(['rev-list', '--count', "HEAD..{$remoteRef}"]);
            $aheadRaw = $this->gitOutput(['rev-list', '--count', "{$remoteRef}..HEAD"]);
            $behind = is_numeric($behindRaw) ? (int) $behindRaw : null;
            $ahead = is_numeric($aheadRaw) ? (int) $aheadRaw : null;
        }

        return [
            'enabled' => $this->isEnabled(),
            'remote' => $remote,
            'branch' => $branch,
            'github_repo' => (string) config('updater.github_repo'),
            'local' => [
                'commit' => $localCommit,
                'short' => $localShort,
                'branch' => $localBranch,
                'message' => $localMessage,
                'date' => $localDate,
                'dirty' => $dirty,
                'dirty_files' => $dirtyFiles,
            ],
            'remote_info' => [
                'ref' => $remoteRef,
                'commit' => $remoteCommit,
                'short' => $remoteCommit !== '' ? substr($remoteCommit, 0, 7) : '',
                'behind' => $behind,
                'ahead' => $ahead,
                'up_to_date' => $behind === 0 && $ahead === 0,
            ],
            'release' => $this->latestRelease(),
            'runtime' => [
                'php' => PHP_VERSION,
                'laravel' => app()->version(),
                'app_env' => config('app.env'),
                'app_version' => (string) config('app.version'),
            ],
            'steps' => $steps,
        ];
    }

    public function check(): array
    {
        return $this->status(fetchRemote: true);
    }

    /**
     * Fast-forward pull from configured remote/branch, then run maintenance.
     *
     * @return array{ok: bool, status: array, steps: list<array>, message?: string}
     */
    public function pull(): array
    {
        $remote = (string) config('updater.remote', 'origin');
        $branch = (string) config('updater.branch', 'main');
        $steps = [];

        $dirtyFiles = $this->dirtyTrackedFiles();
        $preserve = $this->preserveFiles();
        $blocking = array_values(array_diff($dirtyFiles, $preserve));

        if ($blocking !== []) {
            return [
                'ok' => false,
                'message' => 'Local changes block pull: '.implode(', ', $blocking).'. Stash or commit them first.',
                'status' => $this->status(),
                'steps' => $steps,
            ];
        }

        $toStash = array_values(array_intersect($dirtyFiles, $preserve));
        if ($toStash !== []) {
            $steps[] = $this->runGit(array_merge(
                ['stash', 'push', '-m', 'updater-auto-preserve'],
                ['--'],
                $toStash,
            ));
            if (! ($steps[array_key_last($steps)]['ok'] ?? false)) {
                return [
                    'ok' => false,
                    'message' => 'Could not stash server-local files before pull.',
                    'status' => $this->status(),
                    'steps' => $steps,
                ];
            }
        }

        $steps[] = $this->runGit(['fetch', $remote, $branch, '--prune']);
        if (! ($steps[array_key_last($steps)]['ok'] ?? false)) {
            return ['ok' => false, 'status' => $this->status(), 'steps' => $steps];
        }

        $steps[] = $this->runGit(['pull', '--ff-only', $remote, $branch]);
        if (! ($steps[array_key_last($steps)]['ok'] ?? false)) {
            return ['ok' => false, 'status' => $this->status(), 'steps' => $steps];
        }

        // Keep the repo copies of preserve files (drop auto-stash; do not restore old overrides).
        if ($toStash !== []) {
            $drop = $this->runGit(['stash', 'drop']);
            if (! $drop['ok'] && str_contains($drop['output'], 'No stash entries')) {
                $drop['ok'] = true;
            }
            $steps[] = $drop;
        }

        if (config('updater.run_composer')) {
            $steps[] = $this->runShell(
                'composer',
                ['composer', 'install', '--no-dev', '--optimize-autoloader', '--no-interaction'],
            );
        }

        $maintenance = $this->runMaintenance();
        $steps = array_merge($steps, $maintenance['steps']);

        return [
            'ok' => collect($steps)->every(fn (array $step) => $step['ok']),
            'status' => $this->status(),
            'steps' => $steps,
        ];
    }

    /**
     * @return list<string>
     */
    private function dirtyTrackedFiles(): array
    {
        $output = $this->gitOutput(['status', '--porcelain', '--untracked-files=no']);
        if ($output === '') {
            return [];
        }

        $files = [];
        foreach (preg_split("/\r\n|\n|\r/", $output) as $line) {
            $line = rtrim($line);
            if ($line === '') {
                continue;
            }
            // Format: XY PATH or XY ORIG -> PATH
            $path = trim(substr($line, 3));
            if (str_contains($path, ' -> ')) {
                $path = trim(strrchr($path, '>') ?: $path, "> ");
            }
            if ($path !== '') {
                $files[] = $path;
            }
        }

        return array_values(array_unique($files));
    }

    /**
     * @return list<string>
     */
    private function preserveFiles(): array
    {
        $files = config('updater.preserve_files', ['.htaccess', 'index.php']);

        return is_array($files) ? array_values(array_filter($files)) : ['.htaccess', 'index.php'];
    }

    /**
     * @return array{ok: bool, steps: list<array>}
     */
    public function runMaintenance(): array
    {
        $steps = [];

        if (config('updater.run_migrations')) {
            $steps[] = $this->runArtisan(['migrate', '--force']);
        }

        foreach ([
            ['config:clear'],
            ['cache:clear'],
            ['route:clear'],
            ['view:clear'],
            ['optimize:clear'],
        ] as $command) {
            $steps[] = $this->runArtisan($command);
        }

        if (app()->environment('production') && ! config('app.debug')) {
            foreach ([
                ['config:cache'],
                ['route:cache'],
                ['view:cache'],
            ] as $command) {
                $steps[] = $this->runArtisan($command);
            }
        }

        $link = $this->runArtisan(['storage:link']);
        if (! $link['ok'] && str_contains($link['output'], 'already exists')) {
            $link['ok'] = true;
            $link['output'] = 'Storage link already exists (skipped).';
            $link['exit_code'] = 0;
        }
        $steps[] = $link;

        return [
            'ok' => collect($steps)->every(fn (array $step) => $step['ok']),
            'steps' => $steps,
        ];
    }

    public function latestRelease(): ?array
    {
        $repo = (string) config('updater.github_repo');
        if ($repo === '' || ! str_contains($repo, '/')) {
            return null;
        }

        try {
            $request = Http::timeout(12)
                ->acceptJson()
                ->withHeaders([
                    'User-Agent' => 'MediaCreative-Updater',
                ]);

            $token = config('updater.github_token');
            if (is_string($token) && $token !== '') {
                $request = $request->withToken($token);
            }

            $response = $request->get("https://api.github.com/repos/{$repo}/releases/latest");

            if ($response->status() === 404) {
                return [
                    'tag' => null,
                    'name' => 'No GitHub releases published',
                    'url' => "https://github.com/{$repo}",
                    'published_at' => null,
                    'body' => 'Create a GitHub Release to show version tags here. Branch updates still work via git pull.',
                ];
            }

            if (! $response->successful()) {
                return [
                    'tag' => null,
                    'name' => 'Unable to fetch release',
                    'url' => "https://github.com/{$repo}/releases",
                    'published_at' => null,
                    'body' => 'GitHub API returned HTTP '.$response->status(),
                ];
            }

            $data = $response->json();

            return [
                'tag' => $data['tag_name'] ?? null,
                'name' => $data['name'] ?? ($data['tag_name'] ?? null),
                'url' => $data['html_url'] ?? "https://github.com/{$repo}/releases",
                'published_at' => $data['published_at'] ?? null,
                'body' => isset($data['body']) ? mb_substr((string) $data['body'], 0, 800) : null,
            ];
        } catch (Throwable $e) {
            return [
                'tag' => null,
                'name' => 'Release check failed',
                'url' => "https://github.com/{$repo}/releases",
                'published_at' => null,
                'body' => $e->getMessage(),
            ];
        }
    }

    /**
     * @param  list<string>  $args
     * @return array{ok: bool, command: string, output: string, exit_code: int}
     */
    private function runGit(array $args): array
    {
        return $this->runShell('git', array_merge(['git'], $args));
    }

    /**
     * @param  list<string>  $args
     * @return array{ok: bool, command: string, output: string, exit_code: int}
     */
    private function runArtisan(array $args): array
    {
        $php = $this->phpCliBinary();

        return $this->runShell('artisan', array_merge([$php, 'artisan'], $args));
    }

    /**
     * Resolve a PHP CLI binary. PHP_BINARY under FPM points at php-fpm and cannot run Artisan.
     */
    private function phpCliBinary(): string
    {
        $configured = config('updater.php_binary');
        if (is_string($configured) && $configured !== '' && is_executable($configured)) {
            return $configured;
        }

        $candidates = [];

        $envPath = getenv('PHP_BINARY') ?: '';
        if (is_string($envPath) && $envPath !== '') {
            $candidates[] = $envPath;
        }

        if (defined('PHP_BINARY') && is_string(PHP_BINARY) && PHP_BINARY !== '') {
            $candidates[] = PHP_BINARY;
        }

        $version = PHP_MAJOR_VERSION.PHP_MINOR_VERSION;
        $candidates = array_merge($candidates, [
            '/opt/cpanel/ea-php'.$version.'/root/usr/bin/php',
            '/opt/cpanel/ea-php83/root/usr/bin/php',
            '/opt/cpanel/ea-php82/root/usr/bin/php',
            '/usr/local/bin/php',
            '/usr/bin/php',
            'php',
        ]);

        foreach (array_unique($candidates) as $binary) {
            if (! is_string($binary) || $binary === '') {
                continue;
            }

            // Never invoke php-fpm / php-cgi for Artisan.
            $base = strtolower(basename(strtok($binary, ' ') ?: $binary));
            if (str_contains($base, 'fpm') || str_contains($base, 'cgi')) {
                continue;
            }

            if ($binary === 'php' || is_executable($binary)) {
                return $binary;
            }
        }

        return 'php';
    }

    /**
     * @param  list<string>  $command
     * @return array{ok: bool, command: string, output: string, exit_code: int}
     */
    private function runShell(string $label, array $command): array
    {
        $display = $label === 'artisan'
            ? 'php artisan '.implode(' ', array_slice($command, 2))
            : implode(' ', $command);

        try {
            $result = Process::path(base_path())
                ->timeout((int) config('updater.timeout', 180))
                ->run($command);

            $output = trim($result->output()."\n".$result->errorOutput());

            return [
                'ok' => $result->successful(),
                'command' => $display,
                'output' => $output !== '' ? $output : ($result->successful() ? 'OK' : 'Command failed'),
                'exit_code' => $result->exitCode() ?? 1,
            ];
        } catch (Throwable $e) {
            return [
                'ok' => false,
                'command' => $display,
                'output' => $e->getMessage(),
                'exit_code' => 1,
            ];
        }
    }

    /**
     * @param  list<string>  $args
     */
    private function gitOutput(array $args): string
    {
        try {
            $result = Process::path(base_path())
                ->timeout(30)
                ->run(array_merge(['git'], $args));

            return $result->successful() ? trim($result->output()) : '';
        } catch (Throwable) {
            return '';
        }
    }
}
