<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Service;
use App\Services\SeoManager;
use Illuminate\Http\Request;

/**
 * Callers: routes/web.php contact.index / contact.store.
 * Injects SeoManager; store validates ContactMessage fillable fields.
 * User: "pasang seo tools ini dalam project sekarang https://github.com/artesaos/seotools"
 */
class ContactController extends Controller
{
    public function __construct(
        private readonly SeoManager $seo,
    ) {}

    public function index()
    {
        $services = Service::active()->ordered()->get();

        $this->seo->forPage([
            'title' => 'Contact',
            'description' => 'Get in touch with '.site_name().'.',
            'image' => setting('seo.og_image', setting('general.logo', '')),
            'image_alt' => 'Contact '.site_name(),
            'url' => route('contact.index'),
        ]);

        return view('contact.index', compact('services'));
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
