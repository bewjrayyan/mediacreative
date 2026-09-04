<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $team = TeamMember::active()->ordered()->get();

        return view('pages.about', compact('team'));
    }
}
