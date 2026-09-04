<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::active()->ordered()->paginate(9);

        return view('services.index', compact('services'));
    }

    public function show(string $slug)
    {
        $service = Service::active()->where('slug', $slug)->firstOrFail();

        return view('services.show', compact('service'));
    }
}
