<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        return view('frontend.portfolio-rocket-pilot');
    }

    public function about(): View
    {
        return view('frontend.pages.about');
    }

    public function contact(): View
    {
        return view('frontend.pages.contact');
    }

    public function projects(): View
    {
        return view('frontend.pages.projects');
    }

    public function skills(): View
    {
        return view('frontend.pages.skills');
    }

    public function blog(): View
    {
        return view('frontend.pages.blog');
    }
}
