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

        $result = $updater->pull();

        return response()->json([
            'ok' => $result['ok'],
            'message' => $result['message'] ?? ($result['ok']
                ? 'Pulled latest changes and ran post-update Artisan tasks.'
                : 'Update finished with errors. Review the command output.'),
            'data' => $result['status'],
            'steps' => $result['steps'],
        ], $result['ok'] ? 200 : 422);
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

    public function clearCache(SystemUpdater $updater): JsonResponse
    {
        if (! auth()->user()?->isAdmin()) {
            abort(403, 'Only administrators can clear caches.');
        }

        $result = $updater->clearCaches();

        return response()->json([
            'ok' => $result['ok'],
            'message' => $result['ok']
                ? 'Caches cleared. Reloading this page…'
                : 'Some cache clear commands failed. Review the output.',
            'steps' => $result['steps'],
            'reload' => $result['ok'],
        ], $result['ok'] ? 200 : 500);
    }

    private function ensureEnabled(SystemUpdater $updater): void
    {
        if (! $updater->isEnabled()) {
            abort(403, 'System updater is disabled.');
        }
    }
}
