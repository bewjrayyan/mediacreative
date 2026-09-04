<?php

return [

    /*
    |--------------------------------------------------------------------------
    | System updater
    |--------------------------------------------------------------------------
    |
    | Allows administrators to check GitHub releases and pull the latest
    | code from the configured remote branch, then run safe Artisan tasks.
    |
    */

    'enabled' => env('UPDATER_ENABLED', true),

    'remote' => env('UPDATER_REMOTE', 'origin'),

    'branch' => env('UPDATER_BRANCH', 'main'),

    /*
    | GitHub repository in owner/repo form (used for release API lookups).
    */
    'github_repo' => env('UPDATER_GITHUB_REPO', 'bewjrayyan/mediacreative'),

    /*
    | Optional GitHub token for higher API rate limits / private repos.
    */
    'github_token' => env('UPDATER_GITHUB_TOKEN'),

    /*
    | Run `php artisan migrate --force` after a successful pull.
    */
    'run_migrations' => env('UPDATER_RUN_MIGRATIONS', true),

    /*
    | Run `composer install --no-dev --optimize-autoloader` after pull.
    | Disable on hosts where Composer is unavailable or memory-limited.
    */
    'run_composer' => env('UPDATER_RUN_COMPOSER', false),

    'timeout' => (int) env('UPDATER_TIMEOUT', 180),

    /*
    | Absolute path to the PHP CLI binary used for Artisan after pull.
    | Leave empty to auto-detect (never use php-fpm from PHP_BINARY).
    */
    'php_binary' => env('UPDATER_PHP_BINARY'),

    /*
    | Server-local tracked files that are stashed automatically before pull
    | (e.g. shared-hosting .htaccess tweaks) so git pull is not blocked.
    | After a successful pull the stash is dropped and the repo copy is kept.
    */
    'preserve_files' => array_values(array_filter(array_map(
        'trim',
        explode(',', (string) env('UPDATER_PRESERVE_FILES', '.htaccess,index.php'))
    ))),

];
