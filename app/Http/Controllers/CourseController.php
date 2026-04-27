<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('is_published', true)
        ->with('videoCategory')
        ->orderBy('published_at', 'desc')
        ->paginate(9);


        return view('pages.formation', ['courses' => $courses]);
    }

    public function show(string $slug)
    {
        $course = Course::where('slug', $slug)->where('is_published', true)->firstOrFail();
        
        // Incrémentation des vues
        $course->incrementViews();

        // Vidéos similaires (même catégorie, sauf la vidéo actuelle)
        $relatedCourses = Course::where('blog_category_id', $course->blog_category_id)
            ->where('id', '!=', $course->id)
            ->where('is_published', true)
            ->take(2)
            ->get();

        return view('pages.formation-show', ['course' => $course, 'relatedCourses' => $relatedCourses]);
    }
}
