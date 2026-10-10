
@extends('layouts.app')

@section('title', 'Projects')
@section('description', 'Explore my software development projects.')

@section('content')
<section class="page">
    <div class="wrap">
        <span class="eyebrow">Things I've built</span>
        <h1 class="heading">Featured Projects<span style="color:var(--accent)">.</span></h1>
        <p class="lead">
            A collection of applications, experiments, and projects
            created while learning and building.
        </p>

        <div class="filter-row" id="project-filters">
            <button class="filter-btn active" data-filter="all">All Projects</button>
            <button class="filter-btn" data-filter="web">Web Development</button>
            <button class="filter-btn" data-filter="app">Applications</button>
            <button class="filter-btn" data-filter="ai">AI / ML</button>
        </div>

        <div class="grid" id="project-grid">
            <article class="card project-card" data-category="web">
                <div class="icon-box">🛒</div>
                <span class="tag">Web Development</span>
                <h2 class="section-heading" style="margin-top:12px">Haatify</h2>
                <p>
                    An ecommerce platform concept with product listings,
                    categories, cart, orders, and an admin panel.
                </p>
                <div>
                    <span class="tag">Laravel</span>
                    <span class="tag">MySQL</span>
                    <span class="tag">PHP</span>
                </div>
                <div class="actions">
                    <a class="btn btn-secondary"
                       href="https://github.com/" target="_blank"
                       rel="noopener noreferrer">GitHub ↗</a>
                </div>
            </article>

            <article class="card project-card" data-category="app">
                <div class="icon-box">📱</div>
                <span class="tag">Application</span>
                <h2 class="section-heading" style="margin-top:12px">Orvi Task</h2>
                <p>
                    A task management application concept focused on
                    organizing activities and improving productivity.
                </p>
                <div>
                    <span class="tag">Flutter</span>
                    <span class="tag">Dart</span>
                </div>
                <div class="actions">
                    <a class="btn btn-secondary"
                       href="https://github.com/" target="_blank"
                       rel="noopener noreferrer">GitHub ↗</a>
                </div>
            </article>

            <article class="card project-card" data-category="web">
                <div class="icon-box">👨‍💻</div>
                <span class="tag">Web Development</span>
                <h2 class="section-heading" style="margin-top:12px">Developer Portfolio</h2>
                <p>
                    A personal website showcasing my background, skills,
                    projects, articles, and contact information.
                </p>
                <div>
                    <span class="tag">Laravel</span>
                    <span class="tag">Blade</span>
                    <span class="tag">CSS</span>
                </div>
                <div class="actions">
                    <a class="btn btn-primary" href="{{ route('about') }}">
                        View Website ↗
                    </a>
                </div>
            </article>

            <article class="card project-card" data-category="ai">
                <div class="icon-box">🧠</div>
                <span class="tag">AI / ML</span>
                <h2 class="section-heading" style="margin-top:12px">AI Learning Lab</h2>
                <p>
                    A place to develop small experiments in data analysis,
                    prediction, and machine learning.
                </p>
                <div>
                    <span class="tag">Python</span>
                    <span class="tag">Pandas</span>
                    <span class="tag">ML</span>
                </div>
                <div class="actions">
                    <a class="btn btn-secondary"
                       href="https://github.com/" target="_blank"
                       rel="noopener noreferrer">GitHub ↗</a>
                </div>
            </article>
        </div>
    </div>
</section>

<script>
    document.querySelectorAll('#project-filters .filter-btn').forEach(button => {
        button.addEventListener('click', () => {
            document.querySelectorAll('#project-filters .filter-btn')
                .forEach(item => item.classList.remove('active'));

            button.classList.add('active');

            const filter = button.dataset.filter;

            document.querySelectorAll('#project-grid .project-card')
                .forEach(card => {
                    card.hidden = filter !== 'all'
                        && card.dataset.category !== filter;
                });
        });
    });
</script>
@endsection
