@extends('layouts.app')
@section('content')

<section id="home" class="nova-hero relative isolate overflow-hidden bg-[#f8f6f3] text-[#17120f] transition-colors duration-500 dark:bg-[#080808] dark:text-white">

    {{-- Atmospheric background --}}
    <div class="nova-grain pointer-events-none absolute inset-0"></div>
    <div class="nova-glow nova-glow-a pointer-events-none absolute"></div>
    <div class="nova-glow nova-glow-b pointer-events-none absolute"></div>

    {{-- Top editorial label --}}
    <div class="relative z-20 mx-auto flex max-w-[1600px] items-center justify-between px-6 pt-28 sm:px-10 lg:px-16">
        <div class="flex items-center gap-3">
            <span class="h-2 w-2 rounded-full bg-orange-500 shadow-[0_0_15px_#f97316]"></span>
            <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-stone-500 dark:text-stone-400">
                Independent Developer / Nepal
            </span>
        </div>

        <span class="hidden font-mono text-[10px] tracking-[0.2em] text-stone-400 sm:block">
            PORTFOLIO — 2026
        </span>
    </div>

    <div class="relative z-10 mx-auto grid min-h-[720px] max-w-[1600px] items-center gap-2 px-6 pb-20 pt-12 sm:px-10 lg:grid-cols-[1.05fr_0.95fr] lg:px-16 lg:py-12">

        {{-- LEFT: TYPOGRAPHIC HERO --}}
        <div class="nova-copy relative z-20 py-10 lg:py-16">

            <p class="mb-7 text-xs font-semibold uppercase tracking-[0.35em] text-orange-600 dark:text-orange-400">
                Digital craft meets intelligence
            </p>

            <h1 class="nova-title max-w-4xl text-[clamp(3.5rem,8vw,8rem)] font-semibold leading-[0.88] tracking-[-0.075em]">
                Building
                <span class="block">what's</span>
                <span class="nova-title-accent block">next<span class="text-orange-500">.</span></span>
            </h1>

            <div class="mt-9 grid max-w-xl grid-cols-[3px_1fr] gap-5">
                <div class="rounded-full bg-gradient-to-b from-orange-500 to-orange-500/10"></div>

                <div>
                    <h2 class="text-lg font-medium tracking-tight sm:text-xl">
                        {{ optional($profile)->name ?? 'Your Name' }}
                        <span class="text-orange-500">—</span>
                        {{ optional($profile)->headline ?? 'Software Engineer & AI Builder' }}
                    </h2>

                    <p class="mt-3 max-w-lg text-sm leading-7 text-stone-600 sm:text-base dark:text-stone-400">
                        {{ optional($profile)->bio ?? 'I build thoughtful digital experiences, intelligent applications and software that turns ambitious ideas into reality.' }}
                    </p>
                </div>
            </div>

            <div class="mt-9 flex flex-wrap items-center gap-4">
                <a href="{{ route('projects') }}" class="nova-cta group inline-flex items-center gap-8 rounded-full bg-orange-500 px-6 py-4 text-sm font-semibold text-white transition duration-300 hover:-translate-y-1 hover:bg-orange-600 dark:text-black">
                    Explore my work
                    <span class="text-lg transition-transform group-hover:translate-x-1">↗</span>
                </a>

                <a href="{{ route('about') }}" class="group inline-flex items-center gap-3 px-3 py-4 text-sm font-medium text-stone-600 transition hover:text-orange-500 dark:text-stone-300">
                    Discover my story
                    <span class="transition-transform group-hover:translate-x-1">→</span>
                </a>
            </div>

            <div class="mt-12 flex flex-wrap items-center gap-x-5 gap-y-3 border-t border-stone-300/70 pt-6 text-[11px] uppercase tracking-[0.18em] text-stone-500 dark:border-white/10 dark:text-stone-400">
                <a href="https://github.com/thakalihone-beep" target="_blank" rel="noopener noreferrer" class="transition hover:text-orange-500">GitHub ↗</a>
                <span class="text-orange-500">/</span>
                <a href="https://www.linkedin.com/in/roshan-gauchan-33381b417" target="_blank" rel="noopener noreferrer" class="transition hover:text-orange-500">LinkedIn ↗</a>
                <span class="text-orange-500">/</span>
                <a href="mailto:roshangauchan.thakali01@gmail.com" class="transition hover:text-orange-500">Email ↗</a>
            </div>

        </div>

        {{-- RIGHT: IMMERSIVE 3D ART DIRECTION --}}
        <div class="nova-stage relative mx-auto h-[440px] w-full max-w-[700px] sm:h-[570px] lg:h-[700px]">

            <div class="nova-stage-label absolute left-1/2 top-1/2 z-10 -translate-x-1/2 -translate-y-1/2">
                <div id="three-hero" class="h-[440px] w-[440px] max-w-[110vw] sm:h-[580px] sm:w-[580px]" aria-label="Interactive animated three-dimensional orange geometric sculpture"></div>
            </div>

            {{-- Technical annotations --}}
            <div class="nova-hud absolute left-0 top-[14%] z-20">
                <span class="block font-mono text-[9px] tracking-[0.25em] text-orange-600 dark:text-orange-400">FIG. 001</span>
                <span class="mt-2 block text-[10px] uppercase tracking-[0.15em] text-stone-500 dark:text-stone-400">Digital matter</span>
                <span class="mt-1 block font-mono text-[9px] text-stone-400">X / Y / Z</span>
            </div>

            <div class="nova-hud absolute right-0 top-[25%] z-20 text-right">
                <span class="block font-mono text-[9px] tracking-[0.2em] text-stone-500 dark:text-stone-400">SYSTEM STATUS</span>
                <span class="mt-2 flex items-center justify-end gap-2 text-[10px] uppercase tracking-[0.15em]">
                    <span class="h-1.5 w-1.5 rounded-full bg-orange-500"></span>
                    Creating
                </span>
            </div>

            <div class="nova-coordinate absolute bottom-[12%] left-[8%] z-20 font-mono text-[9px] leading-5 text-stone-400">
                <span class="block">ENGINE: THREE.JS</span>
                <span class="block">MODE: INTERACTIVE</span>
                <span class="block">COLOR: #F97316</span>
            </div>

            <div class="nova-coordinate absolute bottom-[13%] right-[2%] z-20 text-right">
                <span class="block text-3xl font-light tracking-tighter text-stone-300 dark:text-white/15">01<span class="text-orange-500">/</span>04</span>
                <span class="mt-1 block text-[9px] uppercase tracking-[0.2em] text-stone-500 dark:text-stone-400">Explore · Build · Repeat</span>
            </div>

            <div class="nova-cross nova-cross-one absolute left-[50%] top-[8%]"></div>
            <div class="nova-cross nova-cross-two absolute bottom-[8%] left-[50%]"></div>

        </div>

    </div>

    {{-- Bottom technology ticker --}}
    <div class="relative z-20 border-y border-stone-300/70 dark:border-white/10">
        <div class="mx-auto flex max-w-[1600px] flex-wrap items-center justify-between gap-5 px-6 py-5 sm:px-10 lg:px-16">
            <span class="text-[10px] uppercase tracking-[0.25em] text-stone-500 dark:text-stone-400">Working across disciplines</span>

            <div class="flex flex-wrap gap-x-6 gap-y-3 text-xs font-medium text-stone-600 dark:text-stone-300 sm:gap-x-9">
                <span>Laravel</span>
                <span class="text-orange-500">✳</span>
                <span>Flutter</span>
                <span class="text-orange-500">✳</span>
                <span>Python / AI</span>
                <span class="text-orange-500">✳</span>
                <span>Three.js</span>
                <span class="text-orange-500">✳</span>
                <span>Machine Learning</span>
            </div>
        </div>
    </div>

</section>

@endsection

