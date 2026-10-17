<footer class="site-footer">
    <div class="site-footer-inner mx-auto max-w-7xl px-6 py-8 sm:px-8 sm:py-10">
        <div>
            <a href="{{ route('home') }}" class="site-footer-brand">RG<span>.</span></a>
            <p class="site-footer-note">Independent digital systems · Nepal</p>
        </div>

        <nav class="site-footer-links" aria-label="Footer navigation">
            <a href="{{ route('about') }}">About</a>
            <a href="{{ route('projects') }}">Projects</a>
            <a href="{{ route('skills') }}">Skills</a>
            <a href="{{ route('blog') }}">Journal</a>
            <a href="{{ route('contact') }}">Contact</a>
            <a href="https://github.com/thakalihone-beep" target="_blank" rel="noopener noreferrer">GitHub ↗</a>
            <a href="https://www.linkedin.com/in/roshan-gauchan-33381b417" target="_blank" rel="noopener noreferrer">LinkedIn ↗</a>
        </nav>

        <p class="site-footer-copy">© {{ date('Y') }} {{ optional($profile)->name ?? 'Roshan Gauchan' }}. Built with curiosity and care.</p>
    </div>
</footer>