<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/',[HomeController::class, 'index'])->name('home');

Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/project', function () {
    return view('pages.project');
})->name('project');



Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');


Route::get('/blog', function () {
    return view('pages.blog');
})->name('blog');



Route::get('/download-media/{media}', [DownloadController::class, 'show'])
    ->name('media.download')
    ->middleware(['auth']); // Sécurise l'accès aux plans

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
