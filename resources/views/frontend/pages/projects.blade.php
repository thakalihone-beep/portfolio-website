
@extends('layouts.app')

@section('title', 'Projects')
@section('description', 'Explore my software development projects.')

@section('content')
<section class="page">
    <div class="wrap">
        <span class="eyebrow">Things I've built</span>
        <h1 class="heading">Featured Projects<span style="color:var(--accent)">.</span></h1>
        <p class="lead">
            Selected applications and experiments from my work.
        </p>

        @if ($projects->isEmpty())
            <p class="muted" role="status">No projects have been published yet.</p>
        @else
            <div class="grid" id="project-grid">
                @foreach ($projects as $project)
                    <article class="card project-card">
                        @if ($project->featured)
                            <span class="tag">Featured</span>
                        @endif

                        <h2 class="section-heading" style="margin-top:12px">{{ $project->title }}</h2>

                        @if ($project->short_description)
                            <p>{{ $project->short_description }}</p>
                        @endif

                        @if ($project->technologies->isNotEmpty())
                            <div class="mt-5">
                                @foreach ($project->technologies as $technology)
                                    <span class="tag">{{ $technology->name }}</span>
                                @endforeach
                            </div>
                        @endif

                        @if ($project->github_url || $project->live_url || $project->demo_url)
                            <div class="actions">
                                @if ($project->github_url)
                                    <a class="btn btn-secondary" href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer">Source ↗</a>
                                @endif
                                @if ($project->live_url)
                                    <a class="btn btn-primary" href="{{ $project->live_url }}" target="_blank" rel="noopener noreferrer">Live Site ↗</a>
                                @endif
                                @if ($project->demo_url)
                                    <a class="btn btn-secondary" href="{{ $project->demo_url }}" target="_blank" rel="noopener noreferrer">Demo ↗</a>
                                @endif
                            </div>
                        @endif
                    </article>
                @endforeach
            </div>

            <div class="mt-8">{{ $projects->links() }}</div>
        @endif
    </div>
</section>
@endsection
