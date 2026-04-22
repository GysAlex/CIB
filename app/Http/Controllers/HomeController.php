<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $latestPosts = BlogPost::with(['blogCategory', 'media'])
            ->published() 
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->take(3)
            ->get();

        // 2. Formater les données pour Alpine.js
        $formattedPosts = $latestPosts->map(function ($post) {
            return [
                'id' => $post->id,
                'slug' => $post->slug,
                'title' => $post->title,
                'category' => $post->blogCategory->name,
                'date' => $post->published_at->translatedFormat('d F Y'),
                'author' => $post->user->name,
                'readTime' => $this->calculateReadTime($post->content),
                'image' => $post->getFirstMediaUrl('blog_posts') ?: asset('images/gcp3.jpg'),
            ];
        });

        // 3. Séparer le "Featured" des autres
        $featuredPost = $formattedPosts->first();
        $otherPosts = $formattedPosts->skip(1)->values();

        return view('pages.home', ['featuredPost' => $featuredPost,  'otherPosts' => $otherPosts ]);
    }

    /**
     * Calcule le temps de lecture estimé
     */
    private function calculateReadTime($content)
    {
        $wordsPerMinute = 200;
        $wordCount = str_word_count(strip_tags($content));
        $minutes = ceil($wordCount / $wordsPerMinute);
        return  $minutes > 1 ? $minutes . ' mins' : $minutes . ' min';
    }
}
