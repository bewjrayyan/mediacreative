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

];
