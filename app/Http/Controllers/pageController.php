<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\ContactMessage;
use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(): View
    {
        return view('frontend.portfolio-rocket');
    }

    public function about(): View
    {
        return view('frontend.pages.about');
    }

    public function contact(): View
    {
        return view('frontend.pages.contact');
    }

    public function storeContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactMessage::create($validated);

        return to_route('contact')->with(
            'status',
            'Thanks for reaching out. Your message has been received.'
        );
    }

    public function projects(): View
    {
        $projects = Project::query()
            ->with('technologies')
            ->where('is_published', true)
            ->orderByDesc('featured')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->paginate(9);

        return view('frontend.pages.projects', compact('projects'));
    }

    public function skills(): View
    {
        return view('frontend.pages.skills');
    }

    public function blog(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $search = trim($validated['search'] ?? '');

        $posts = BlogPost::query()
            ->with('category')
            ->where('status', 'published')
            ->where(function ($query): void {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('excerpt', 'like', "%{$search}%")
                        ->orWhereHas('category', function ($query) use ($search): void {
                            $query->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(9)
            ->withQueryString();

        return view('frontend.pages.blog', compact('posts', 'search'));
    }

    public function showBlog(BlogPost $blogPost): View
    {
        abort_unless(
            $blogPost->status === 'published'
                && ($blogPost->published_at === null || ! $blogPost->published_at->isFuture()),
            404
        );

        $blogPost->increment('views');
        $blogPost->load('category', 'tags');

        return view('frontend.pages.blog-show', ['blogPost' => $blogPost]);
    }
}
