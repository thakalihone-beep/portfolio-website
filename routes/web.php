<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.home');
})->name('home');


Route::get('/about', function () {
    return view('frontend.pages.about');
})->name('about');


Route::get('/contact', function () {
    return view('frontend.pages.contact');
})->name('contact');


Route::get('/projects', function () {
    return view('frontend.pages.projects');
})->name('projects');


Route::get('/skills', function () {
    return view('frontend.pages.skills');
})->name('skills');


Route::get('/blog', function () {
    return view('frontend.pages.blog');
})->name('blog');
