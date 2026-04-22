<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function show($slug)
    {
        $post = BlogPost::with(['blogCategory', 'blogTags', 'media'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Récupérer 3 articles similaires (même catégorie, excluant l'actuel)
        $relatedPosts = BlogPost::published()
            ->where('blog_category_id', $post->blog_category_id)
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(3)
            ->get();

        return view('pages.blog-show', ['post' => $post, 'relatedPosts' => $relatedPosts]);
    }

}
