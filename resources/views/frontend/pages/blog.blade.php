
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

        <div class="field" style="max-width:520px; margin-top:30px">
            <label for="blog-search">Search articles</label>
            <input id="blog-search" type="search"
                   placeholder="Search Laravel, Python, AI...">
        </div>

        <div class="filter-row" id="blog-filters">
            <button class="filter-btn active" data-filter="all">All</button>
            <button class="filter-btn" data-filter="programming">Programming</button>
            <button class="filter-btn" data-filter="laravel">Laravel</button>
            <button class="filter-btn" data-filter="ai">AI / ML</button>
        </div>

        <div class="grid" id="blog-grid">
            <article class="card blog-card"
                     data-category="laravel"
                     data-search="laravel models migrations database">
                <div class="icon-box">⚙️</div>
                <span class="tag">Laravel</span>
                <h2 class="section-heading" style="margin-top:12px">
                    Understanding Laravel Models and Migrations
                </h2>
                <p>
                    Learn how Eloquent models, database tables, and
                    migrations work together in a Laravel application.
                </p>
                <p class="muted">Beginner · 6 min read</p>
                <a class="btn btn-secondary" href="#"
                   onclick="event.preventDefault(); alert('Connect this article to your blog post detail page.');">
                    Read Article ↗
                </a>
            </article>

            <article class="card blog-card"
                     data-category="programming"
                     data-search="python programming beginner variables functions">
                <div class="icon-box">🐍</div>
                <span class="tag">Programming</span>
                <h2 class="section-heading" style="margin-top:12px">
                    Building Strong Programming Foundations
                </h2>
                <p>
                    Why variables, conditions, loops, functions, and
                    problem-solving matter for every developer.
                </p>
                <p class="muted">Beginner · 5 min read</p>
                <a class="btn btn-secondary" href="#"
                   onclick="event.preventDefault(); alert('Connect this article to your blog post detail page.');">
                    Read Article ↗
                </a>
            </article>

            <article class="card blog-card"
                     data-category="ai"
                     data-search="machine learning deep learning generative ai">
                <div class="icon-box">🤖</div>
                <span class="tag">AI / ML</span>
                <h2 class="section-heading" style="margin-top:12px">
                    Machine Learning vs Deep Learning
                </h2>
                <p>
                    Explore the relationship between machine learning,
                    neural networks, deep learning, and generative AI.
                </p>
                <p class="muted">AI / ML · 8 min read</p>
                <a class="btn btn-secondary" href="#"
                   onclick="event.preventDefault(); alert('Connect this article to your blog post detail page.');">
                    Read Article ↗
                </a>
            </article>
        </div>

        <p id="blog-empty" class="muted" hidden>
            No matching articles found. Try another search.
        </p>
    </div>
</section>

<script>
    const searchInput = document.getElementById('blog-search');
    const blogCards = [...document.querySelectorAll('#blog-grid .blog-card')];
    const blogButtons = [...document.querySelectorAll('#blog-filters .filter-btn')];
    let selectedCategory = 'all';

    function filterBlogs() {
        const query = searchInput.value.toLowerCase().trim();
        let visible = 0;

        blogCards.forEach(card => {
            const categoryMatch = selectedCategory === 'all'
                || card.dataset.category === selectedCategory;

            const searchMatch = card.dataset.search.includes(query)
                || card.innerText.toLowerCase().includes(query);

            const show = categoryMatch && searchMatch;
            card.hidden = !show;

            if (show) visible++;
        });

        document.getElementById('blog-empty').hidden = visible !== 0;
    }

    searchInput.addEventListener('input', filterBlogs);

    blogButtons.forEach(button => {
        button.addEventListener('click', () => {
            selectedCategory = button.dataset.filter;

            blogButtons.forEach(item => item.classList.remove('active'));
            button.classList.add('active');

            filterBlogs();
        });
    });
</script>
@endsection
