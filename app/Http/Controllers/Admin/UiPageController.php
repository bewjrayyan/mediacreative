<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class UiPageController extends Controller
{
    private const PAGES = [
        'email' => 'admin.ui.email',
        'compose' => 'admin.ui.compose',
        'calendar' => 'admin.ui.calendar',
        'chat' => 'admin.ui.chat',
        'charts' => 'admin.ui.charts',
        'forms' => 'admin.ui.forms',
        'ui' => 'admin.ui.ui',
        'buttons' => 'admin.ui.buttons',
        'basic-table' => 'admin.ui.basic-table',
        'datatable' => 'admin.ui.datatable',
        'google-maps' => 'admin.ui.google-maps',
        'vector-maps' => 'admin.ui.vector-maps',
        'blank' => 'admin.ui.blank',
        '404' => 'admin.ui.404',
        '500' => 'admin.ui.500',
        'signup' => 'admin.ui.signup',
    ];

    public function show(string $page): View
    {
        abort_unless(isset(self::PAGES[$page]), 404);

        return view(self::PAGES[$page]);
    }
}
