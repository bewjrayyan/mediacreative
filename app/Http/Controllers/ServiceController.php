<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::active()->ordered()->paginate(9);
        $clients = Client::active()->ordered()->take(12)->get();

        return view('services.index', compact('services', 'clients'));
    }

    public function show(string $slug)
    {
        $service = Service::active()->where('slug', $slug)->firstOrFail();

        return view('services.show', compact('service'));
    }
}
