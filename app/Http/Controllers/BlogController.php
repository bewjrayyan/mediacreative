<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::published()->latest()->paginate(6);

        return view('blog.index', compact('posts'));
    }

    public function show(string $slug)
    {
        $post = Post::published()->where('slug', $slug)->firstOrFail();
        $recent = Post::published()->where('id', '!=', $post->id)->latest()->take(4)->get();

        return view('blog.show', compact('post', 'recent'));
    }
}
