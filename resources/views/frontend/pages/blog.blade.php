
@extends('layouts.app')

@section('title', 'Blog')
@section('description', 'Articles, tutorials, and notes on software development and AI.')

@section('content')
<section class="page">
    <div class="wrap">
        <span class="eyebrow">Ideas worth sharing</span>
        <h1 class="heading">The Developer Journal<span style="color:var(--accent)">.</span></h1>
        <p class="lead">
            Notes from my learning journey, programming tutorials,
            project lessons, and explorations in artificial intelligence.
        </p>

        <form action="{{ route('blog') }}" method="get" class="field" style="max-width:520px; margin-top:30px">
            <label for="blog-search">Search published articles</label>
            <div class="flex gap-3">
                <input id="blog-search" name="search" type="search"
                       value="{{ $search }}" maxlength="100"
                       placeholder="Search articles...">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>

        @if ($posts->isEmpty())
            <p class="muted" role="status">
                {{ $search ? 'No published articles match your search.' : 'No articles have been published yet.' }}
            </p>
        @else
            <div class="grid" id="blog-grid">
                @foreach ($posts as $post)
                    <article class="card blog-card">
                        <span class="tag">{{ $post->category?->name ?? 'Journal' }}</span>
                        <h2 class="section-heading" style="margin-top:12px">{{ $post->title }}</h2>
                        @if ($post->excerpt)
                            <p>{{ $post->excerpt }}</p>
                        @endif
                        <p class="muted">
                            {{ $post->published_at?->format('M j, Y') ?? 'Published' }}
                        </p>
                        <div class="actions">
                            <a class="btn btn-secondary" href="{{ route('blog.show', $post->slug) }}">
                                Read Article ↗
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-8">{{ $posts->links() }}</div>
        @endif
    </div>
</section>
@endsection
