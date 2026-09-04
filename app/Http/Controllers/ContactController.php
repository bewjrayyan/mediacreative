<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Service;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $services = Service::active()->ordered()->get();

        return view('pages.contact', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'subject' => ['nullable', 'string', 'max:255'],
            'service_id' => ['nullable', 'exists:services,id'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactMessage::create($validated);

        return redirect()->route('contact.index')
            ->with('success', 'Thank you! Your message has been sent. We\'ll get back to you shortly.');
    }
}
