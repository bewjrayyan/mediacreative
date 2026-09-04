<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::active()->ordered()->take(6)->get();
        $featuredProjects = Project::published()->featured()->take(6)->get();
        $testimonials = Testimonial::active()->ordered()->take(6)->get();
        $clients = Client::active()->ordered()->take(8)->get();

        return view('pages.home', compact('services', 'featuredProjects', 'testimonials', 'clients'));
    }
}
