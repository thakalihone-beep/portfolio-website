@extends('layouts.app')
@section('content')
    <section id="home"
        class="relative flex min-h-screen items-center overflow-hidden bg-white transition-colors duration-300 dark:bg-[#0b0b0b]">


    <!-- Background Decorations -->

    <div class="absolute -right-40 top-20 h-96 w-96 rounded-full bg-orange-500/10 blur-3xl">
    </div>

    <div class="absolute -left-40 bottom-20 h-96 w-96 rounded-full bg-orange-500/5 blur-3xl">
    </div>


    <div class="relative mx-auto grid max-w-7xl items-center gap-16 px-6 pb-20 pt-32 lg:grid-cols-2">


        <!-- Hero Content -->

        <div>

            <p class="mb-5 text-sm font-medium uppercase tracking-[0.3em] text-orange-500">

                Hello, I'm

            </p>


            <h1
                class="text-5xl font-bold leading-tight tracking-tight text-gray-900 sm:text-6xl lg:text-7xl dark:text-white">

                {{ $profile->name ?? 'Your Name' }}

            </h1>


            <h2 class="mt-5 text-2xl font-semibold text-gray-700 sm:text-3xl dark:text-gray-300">

                {{ $profile->headline ?? 'Software Engineer & AI Builder' }}

            </h2>


            <p class="mt-6 max-w-xl text-lg leading-8 text-gray-600 dark:text-gray-400">

                {{ $profile->short_bio ?? 'I build modern websites, applications and intelligent software solutions using technology, creativity and problem solving.' }}

            </p>


            <!-- Buttons -->

            <div class="mt-10 flex flex-wrap gap-4">

                <a href="#projects"
                    class="rounded-full bg-orange-500 px-7 py-3.5 font-semibold text-white transition hover:bg-orange-600 dark:text-black">

                    View My Work

                </a>


                <!-- CV LINK -->

                <a href="#"
                    class="rounded-full border border-gray-300 px-7 py-3.5 font-semibold text-gray-800 transition hover:border-orange-400 hover:text-orange-500 dark:border-white/20 dark:text-white dark:hover:border-orange-400 dark:hover:text-orange-400">

                    Download CV

                </a>

            </div>


            <!-- Social Links -->

            <div class="mt-10 flex items-center gap-5">

                <a href="#" target="_blank"
                    class="text-sm text-gray-500 transition hover:text-orange-500 dark:text-gray-400 dark:hover:text-orange-400">

                    GitHub

                </a>

                <span class="text-gray-300 dark:text-gray-700">/</span>

                <a href="#" target="_blank"
                    class="text-sm text-gray-500 transition hover:text-orange-500 dark:text-gray-400 dark:hover:text-orange-400">

                    LinkedIn

                </a>

                <span class="text-gray-300 dark:text-gray-700">/</span>

                <a href="mailto:your@email.com"
                    class="text-sm text-gray-500 transition hover:text-orange-500 dark:text-gray-400 dark:hover:text-orange-400">

                    Email

                </a>

            </div>

        </div>



        <!-- Profile Image -->

        <div class="flex justify-center lg:justify-end">

            <div class="relative">

                <div class="absolute inset-0 rounded-3xl bg-orange-500/20 blur-3xl">
                </div>


                <div
                    class="relative flex h-[420px] w-[350px] items-center justify-center overflow-hidden rounded-3xl border border-gray-200 bg-gray-100 sm:h-[500px] sm:w-[400px] dark:border-white/10 dark:bg-[#151515]">


                    @if (isset($profile->profile_image))
                        <img src="{{ asset('storage/' . $profile->profile_image) }}" alt="{{ $profile->name }}"
                            class="h-full w-full object-cover">
                    @else
                        <div class="text-center">

                            <div
                                class="mx-auto mb-5 flex h-24 w-24 items-center justify-center rounded-full bg-orange-500/10 text-4xl">

                                👤

                            </div>

                            <p class="text-gray-500">
                                Your Photo
                            </p>

                        </div>
                    @endif

                </div>

            </div>

        </div>

    </div>

</section>



<!-- =====================================================
             ABOUT
        ====================================================== -->

<section id="about" class="border-t border-gray-200 py-28 transition-colors duration-300 dark:border-white/10">

    <div class="mx-auto max-w-7xl px-6">

        <div class="grid gap-16 lg:grid-cols-2">

            <div>

                <p class="text-sm uppercase tracking-[0.3em] text-orange-500">
                    About Me
                </p>

                <h2 class="mt-4 text-4xl font-bold text-gray-900 dark:text-white">

                    Building ideas into real products.

                </h2>

            </div>


            <div>

                <p class="leading-8 text-gray-600 dark:text-gray-400">

                    {{ $profile->bio ?? 'I am a software engineering student passionate about software development, artificial intelligence, web development and building real-world technology products.' }}

                </p>


                <a href="#"
                    class="mt-7 inline-block font-semibold text-orange-500 transition hover:text-orange-600">

                    More About Me →

                </a>

            </div>

        </div>

    </div>

</section>



<!-- =====================================================
             PROJECTS
        ====================================================== -->

<section id="projects"
    class="border-t border-gray-200 bg-gray-50 py-28 transition-colors duration-300 dark:border-white/10 dark:bg-[#101010]">

    <div class="mx-auto max-w-7xl px-6">

        <div class="flex flex-col justify-between gap-5 md:flex-row md:items-end">

            <div>

                <p class="text-sm uppercase tracking-[0.3em] text-orange-500">
                    Selected Work
                </p>

                <h2 class="mt-4 text-4xl font-bold text-gray-900 dark:text-white">

                    Featured Projects

                </h2>

            </div>


            <a href="#"
                class="text-sm font-semibold text-gray-500 transition hover:text-orange-500 dark:text-gray-400 dark:hover:text-orange-400">

                View All Projects →

            </a>

        </div>



        <div class="mt-14 grid gap-7 md:grid-cols-2 lg:grid-cols-3">


            @forelse($projects ?? [] as $project)

                <article
                    class="group overflow-hidden rounded-2xl border border-gray-200 bg-white transition duration-300 hover:-translate-y-2 hover:border-orange-400 dark:border-white/10 dark:bg-[#151515]">


                    <div class="aspect-video overflow-hidden bg-gray-100 dark:bg-[#1c1c1c]">

                        @if ($project->image ?? false)
                            <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        @else
                            <div class="flex h-full items-center justify-center text-gray-500">

                                Project Image

                            </div>
                        @endif

                    </div>


                    <div class="p-6">

                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">

                            {{ $project->title }}

                        </h3>


                        <p class="mt-3 text-sm leading-6 text-gray-600 dark:text-gray-400">

                            {{ $project->description }}

                        </p>


                        <div class="mt-6 flex gap-5">

                            <a href="#" target="_blank"
                                class="text-sm font-semibold text-orange-500 hover:text-orange-600">

                                Live Demo →

                            </a>

                            <a href="#" target="_blank"
                                class="text-sm font-semibold text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">

                                GitHub →

                            </a>

                        </div>

                    </div>

                </article>

            @empty


                @foreach (['Project One', 'Project Two', 'Project Three'] as $projectName)
                    <article
                        class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-white/10 dark:bg-[#151515]">

                        <div
                            class="flex aspect-video items-center justify-center rounded-xl bg-gray-100 text-gray-500 dark:bg-[#1c1c1c]">

                            Project Image

                        </div>


                        <h3 class="mt-6 text-xl font-bold text-gray-900 dark:text-white">

                            {{ $projectName }}

                        </h3>


                        <p class="mt-3 text-sm leading-6 text-gray-600 dark:text-gray-400">

                            Your project description will appear here.

                        </p>


                        <div class="mt-6 flex gap-5">

                            <a href="#" class="text-sm font-semibold text-orange-500">

                                Live Demo →

                            </a>

                            <a href="#" class="text-sm font-semibold text-gray-500 dark:text-gray-400">

                                GitHub →

                            </a>

                        </div>

                    </article>
                @endforeach

            @endforelse

        </div>

    </div>

</section>



<!-- =====================================================
             SKILLS
        ====================================================== -->

<section id="skills" class="border-t border-gray-200 py-28 transition-colors duration-300 dark:border-white/10">

    <div class="mx-auto max-w-7xl px-6">

        <div class="text-center">

            <p class="text-sm uppercase tracking-[0.3em] text-orange-500">
                My Expertise
            </p>

            <h2 class="mt-4 text-4xl font-bold text-gray-900 dark:text-white">

                Technologies I Work With

            </h2>

        </div>


        <div class="mt-14 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">

            @foreach (['Laravel', 'PHP', 'Python', 'JavaScript', 'Flutter', 'MySQL', 'Machine Learning', 'Deep Learning', 'Git', 'Tailwind CSS', 'Filament', 'Artificial Intelligence'] as $skill)
                <div
                    class="rounded-xl border border-gray-200 bg-gray-50 px-5 py-6 text-center transition hover:border-orange-400 hover:bg-white dark:border-white/10 dark:bg-[#111111] dark:hover:bg-[#151515]">

                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">

                        {{ $skill }}

                    </span>

                </div>
            @endforeach

        </div>

    </div>

</section>



<!-- =====================================================
             CONTACT
        ====================================================== -->

<section id="contact"
    class="border-t border-gray-200 bg-gray-50 py-32 transition-colors duration-300 dark:border-white/10 dark:bg-[#101010]">

    <div class="mx-auto max-w-4xl px-6 text-center">

        <p class="text-sm uppercase tracking-[0.3em] text-orange-500">
            Get In Touch
        </p>


        <h2 class="mt-5 text-4xl font-bold text-gray-900 sm:text-5xl dark:text-white">

            Let's build something great.

        </h2>


        <p class="mx-auto mt-6 max-w-2xl leading-8 text-gray-600 dark:text-gray-400">

            Have a project, idea or opportunity?
            I'd love to hear about it.

        </p>


        <a href="mailto:your@email.com"
            class="mt-10 inline-flex rounded-full bg-orange-500 px-8 py-4 font-semibold text-white transition hover:bg-orange-600 dark:text-black">

            Contact Me →

        </a>

    </div>

</section>

@endsection

