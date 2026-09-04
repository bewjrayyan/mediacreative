<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SystemUpdater;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;

class SystemUpdateController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            function ($request, $next) {
                if (! auth()->user()?->isAdmin()) {
                    abort(403, 'Only administrators can manage system updates.');
                }

                return $next($request);
            },
        ];
    }

    public function status(SystemUpdater $updater): JsonResponse
    {
        $this->ensureEnabled($updater);

        return response()->json([
            'ok' => true,
            'data' => $updater->status(),
        ]);
    }

    public function check(SystemUpdater $updater): JsonResponse
    {
        $this->ensureEnabled($updater);

        $data = $updater->check();

        return response()->json([
            'ok' => true,
            'message' => 'Checked remote repository and GitHub release.',
            'data' => $data,
        ]);
    }

    public function pull(SystemUpdater $updater): JsonResponse
    {
        $this->ensureEnabled($updater);

        if (($updater->status()['local']['dirty'] ?? false) === true) {
            return response()->json([
                'ok' => false,
                'message' => 'Working tree has local changes. Commit or stash them before pulling.',
                'data' => $updater->status(),
            ], 422);
        }

        $result = $updater->pull();

        return response()->json([
            'ok' => $result['ok'],
            'message' => $result['ok']
                ? 'Pulled latest changes and ran post-update Artisan tasks.'
                : 'Update finished with errors. Review the command output.',
            'data' => $result['status'],
            'steps' => $result['steps'],
        ], $result['ok'] ? 200 : 500);
    }

    public function maintenance(SystemUpdater $updater): JsonResponse
    {
        $this->ensureEnabled($updater);

        $result = $updater->runMaintenance();

        return response()->json([
            'ok' => $result['ok'],
            'message' => $result['ok']
                ? 'Maintenance Artisan commands completed.'
                : 'Some Artisan commands failed. Review the output.',
            'steps' => $result['steps'],
            'data' => $updater->status(),
        ], $result['ok'] ? 200 : 500);
    }

    private function ensureEnabled(SystemUpdater $updater): void
    {
        if (! $updater->isEnabled()) {
            abort(403, 'System updater is disabled.');
        }
    }
}
