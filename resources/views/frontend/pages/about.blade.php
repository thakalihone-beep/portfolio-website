
@extends('layouts.app')

@section('title', 'About Me')
@section('description', 'Learn about my background, education, interests, and goals.')

@section('content')
<section class="page">
    <div class="wrap">
        <span class="eyebrow">A little about me</span>

        <div class="two-grid" style="align-items:center; margin-top:16px">
            <div>
                <h1 class="heading">
                    Hello, I'm <span style="color:var(--accent)">Your Name.</span>
                </h1>

                <h2 class="section-heading">Software Engineering Student & Aspiring AI Builder</h2>

                <p class="lead">
                    I enjoy turning ideas into useful digital products.
                    I'm learning software engineering, web development,
                    artificial intelligence, and machine learning to build
                    applications that solve real-world problems.
                </p>

                <p class="muted">
                    My goal is to become a strong software engineer, create
                    meaningful products, and continuously improve my technical
                    and problem-solving skills.
                </p>

                <div class="actions">
                    <a href="{{ route('projects') }}" class="btn btn-primary">
                        Explore My Work ↗
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-secondary">
                        Contact Me
                    </a>
                </div>
            </div>

            <div class="hero-panel" style="text-align:center">
                <div style="font-size:85px; margin-bottom:10px">👨‍💻</div>
                <h2 class="section-heading">Curious by nature.</h2>
                <p class="muted">
                    Learn. Build. Experiment. Improve.
                </p>

                <div style="margin-top:20px">
                    <span class="tag">Software Engineering</span>
                    <span class="tag">Laravel</span>
                    <span class="tag">AI / ML</span>
                    <span class="tag">Problem Solving</span>
                </div>
            </div>
        </div>

        <div style="margin-top:80px">
            <span class="eyebrow">My journey</span>
            <h2 class="heading" style="font-size:36px">What drives me</h2>

            <div class="grid">
                <article class="card">
                    <div class="icon-box">🎓</div>
                    <h3>Education</h3>
                    <p>
                        Studying Software Engineering and strengthening
                        my foundations in programming, mathematics, and
                        computer science.
                    </p>
                </article>

                <article class="card">
                    <div class="icon-box">💻</div>
                    <h3>Building Products</h3>
                    <p>
                        Developing websites, applications, and practical
                        projects to turn my knowledge into real experience.
                    </p>
                </article>

                <article class="card">
                    <div class="icon-box">🧠</div>
                    <h3>Exploring AI</h3>
                    <p>
                        Learning data science, machine learning, deep learning,
                        and generative AI step by step.
                    </p>
                </article>
            </div>
        </div>
    </div>
</section>
@endsection
