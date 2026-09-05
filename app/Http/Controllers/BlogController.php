<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\SeoManager;
use Illuminate\Support\Str;

/**
 * Routed from routes/web.php (blog.*). Uses SeoManager for index/show meta.
 * User: "pasang seo tools ini dalam project sekarang https://github.com/artesaos/seotools"
 */
class BlogController extends Controller
{
    public function __construct(
        private readonly SeoManager $seo,
    ) {}

    public function index()
    {
        $posts = Post::published()->latest()->paginate(6);

        $shareImage = $posts->first(fn ($p) => filled($p->cover_image))?->cover_image;

        $this->seo->forPage([
            'title' => 'Blog',
            'description' => 'Articles and updates from '.site_name().'.',
            'image' => $shareImage,
            'image_alt' => 'Blog — '.site_name(),
            'url' => route('blog.index'),
        ]);

        return view('blog.index', compact('posts'));
    }

    public function show(string $slug)
    {
        $post = Post::published()->where('slug', $slug)->firstOrFail();
        $recent = Post::published()->where('id', '!=', $post->id)->latest()->take(4)->get();

        $description = $post->meta_description
            ?: ($post->excerpt
                ? strip_tags((string) $post->excerpt)
                : Str::limit(strip_tags((string) $post->content), 160));

        $this->seo->forPage([
            'title' => $post->meta_title ?: $post->title,
            'description' => $description,
            'keywords' => $post->meta_keywords,
            'image' => $post->cover_image,
            'image_alt' => $post->meta_title ?: $post->title,
            'url' => route('blog.show', $post->slug),
            'type' => 'article',
        ]);

        return view('blog.show', compact('post', 'recent'));
    }
}
