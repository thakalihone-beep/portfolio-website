
@extends('layouts.app')

@section('title', 'Skills')
@section('description', 'My programming languages, frameworks, and technical interests.')

@section('content')
<section class="page">
    <div class="wrap">
        <span class="eyebrow">My capabilities</span>
        <h1 class="heading">Skills & Technologies</h1>
        <p class="lead">
            Technologies I use, study, and explore to build useful software.
            This list can be updated as I gain experience.
        </p>

        <div class="grid">
            <article class="card">
                <div class="icon-box">⌨</div>
                <h2 class="section-heading">Programming</h2>
                <p>Languages and core development foundations.</p>
                <span class="tag">PHP</span>
                <span class="tag">Python</span>
                <span class="tag">JavaScript</span>
                <span class="tag">SQL</span>
                <span class="tag">C / C++</span>
            </article>

            <article class="card">
                <div class="icon-box">🌐</div>
                <h2 class="section-heading">Web Development</h2>
                <p>Building responsive websites and applications.</p>
                <span class="tag">HTML</span>
                <span class="tag">CSS</span>
                <span class="tag">Tailwind CSS</span>
                <span class="tag">Laravel</span>
                <span class="tag">Blade</span>
            </article>

            <article class="card">
                <div class="icon-box">🗄</div>
                <h2 class="section-heading">Databases</h2>
                <p>Data modeling, querying, and persistence.</p>
                <span class="tag">MySQL</span>
                <span class="tag">Database Design</span>
                <span class="tag">Migrations</span>
                <span class="tag">Eloquent ORM</span>
            </article>

            <article class="card">
                <div class="icon-box">🤖</div>
                <h2 class="section-heading">AI & Machine Learning</h2>
                <p>Areas I'm learning and developing practical knowledge in.</p>
                <span class="tag">Python</span>
                <span class="tag">NumPy</span>
                <span class="tag">Pandas</span>
                <span class="tag">Machine Learning</span>
                <span class="tag">Deep Learning</span>
                <span class="tag">Generative AI</span>
            </article>

            <article class="card">
                <div class="icon-box">🛠</div>
                <h2 class="section-heading">Tools</h2>
                <p>Tools for writing, testing, and managing code.</p>
                <span class="tag">VS Code</span>
                <span class="tag">Git</span>
                <span class="tag">GitHub</span>
                <span class="tag">XAMPP</span>
                <span class="tag">PowerShell</span>
            </article>

            <article class="card">
                <div class="icon-box">🚀</div>
                <h2 class="section-heading">Currently Exploring</h2>
                <p>Areas I want to explore through projects.</p>
                <span class="tag">Flutter</span>
                <span class="tag">APIs</span>
                <span class="tag">Robotics</span>
                <span class="tag">IoT</span>
                <span class="tag">Quantitative Finance</span>
            </article>
        </div>

        <p class="muted" style="margin-top:25px">
            Note: Edit these tags to reflect your actual experience.
            Only describe a technology as proficient when you can use it confidently.
        </p>
    </div>
</section>
@endsection
