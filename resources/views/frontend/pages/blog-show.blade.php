@extends('layouts.app')

@section('title', $blogPost->title)
@section('description', $blogPost->excerpt ?? 'An article from the developer journal.')

@section('content')
<section class="page">
    <article class="wrap max-w-3xl">
        <a href="{{ route('blog') }}" class="btn btn-secondary">← Back to Journal</a>

        <header class="mt-10">
            <span class="eyebrow">{{ $blogPost->category?->name ?? 'Developer Journal' }}</span>
            <h1 class="heading">{{ $blogPost->title }}</h1>

            @if ($blogPost->excerpt)
                <p class="lead">{{ $blogPost->excerpt }}</p>
            @endif

            <p class="muted">
                {{ $blogPost->published_at?->format('F j, Y') ?? $blogPost->created_at->format('F j, Y') }}
                <span aria-hidden="true">·</span>
                {{ number_format($blogPost->views) }} views
            </p>
        </header>

        <div class="mt-10 max-w-none whitespace-pre-line text-base leading-8 text-slate-700 dark:text-slate-300">
            {{ $blogPost->content }}
        </div>
    </article>
</section>
@endsection
