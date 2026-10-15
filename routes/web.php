<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');

Route::get('/about', [PageController::class, 'about'])->name('about');

Route::get('/contact', [PageController::class, 'contact'])->name('contact');

Route::get('/projects', [PageController::class, 'projects'])->name('projects');

Route::get('/skills', [PageController::class, 'skills'])->name('skills');

Route::get('/blog', [PageController::class, 'blog'])->name('blog');
