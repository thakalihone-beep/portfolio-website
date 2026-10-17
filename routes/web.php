<?php

use App\Http\Controllers\pageController as PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');

Route::get('/about', [PageController::class, 'about'])->name('about');

Route::get('/contact', [PageController::class, 'contact'])->name('contact');

Route::post('/contact', [PageController::class, 'storeContact'])
    ->middleware('throttle:5,1')
    ->name('contact.store');

Route::get('/projects', [PageController::class, 'projects'])->name('projects');

Route::get('/skills', [PageController::class, 'skills'])->name('skills');

Route::get('/blog', [PageController::class, 'blog'])->name('blog');

Route::get('/blog/{blogPost:slug}', [PageController::class, 'showBlog'])
    ->name('blog.show');
