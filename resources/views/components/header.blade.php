<header
    class="fixed left-0 right-0 top-0 z-50 border-b border-gray-200/80 bg-white/80 backdrop-blur-xl transition-colors duration-300 dark:border-white/10 dark:bg-[#0b0b0b]/80">

    <div class="mx-auto max-w-7xl px-4 sm:px-6">
        <div class="flex items-center justify-between py-4 sm:py-5">

            <!-- Logo -->

            <a href="{{ url('/') }}" class="text-lg font-bold tracking-tight text-gray-900 sm:text-xl dark:text-white">

                {{ optional($profile)->name ?? 'RoshanGauchan' }}

            </a>


            <!-- Desktop Navigation -->

            <nav class="hidden items-center gap-8 md:flex">

                <a href="/"
                    class="text-sm text-gray-600 transition hover:text-orange-500 dark:text-gray-300 dark:hover:text-orange-400">
                    Home
                </a>

                <a href="{{ route('about') }}"
                    class="text-sm text-gray-600 transition hover:text-orange-500 dark:text-gray-300 dark:hover:text-orange-400">
                    About
                </a>

                <a href="{{ route('projects') }}"
                    class="text-sm text-gray-600 transition hover:text-orange-500 dark:text-gray-300 dark:hover:text-orange-400">
                    Projects
                </a>

                <a href="{{ route('skills') }}"
                    class="text-sm text-gray-600 transition hover:text-orange-500 dark:text-gray-300 dark:hover:text-orange-400">
                    Skills
                </a>

                <a href="{{ route('blog') }}"
                    class="text-sm text-gray-600 transition hover:text-orange-500 dark:text-gray-300 dark:hover:text-orange-400">
                    Blog
                </a>

            </nav>


            <!-- Right Side -->

            <div class="flex items-center gap-2 sm:gap-3">


                <!-- Theme Toggle -->

                <button id="theme-toggle" type="button" aria-label="Toggle dark mode"
                    class="flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 bg-gray-100 text-gray-700 transition hover:border-orange-400 hover:text-orange-500 dark:border-white/10 dark:bg-white/5 dark:text-gray-300 dark:hover:border-orange-400 dark:hover:text-orange-400">

                    <!-- Sun -->

                    <svg id="sun-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.8" stroke="currentColor" class="hidden h-5 w-5">

                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-2.636-1.591 1.591M5.25 12H3m3.636-5.364L5.045 5.045M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />

                    </svg>


                    <!-- Moon -->

                    <svg id="moon-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.8" stroke="currentColor" class="h-5 w-5">

                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.752 15.002A9.718 9.718 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.598.748-3.752A9.753 9.753 0 1 0 21.752 15.002Z" />

                    </svg>

                </button>


                <!-- Contact Button -->

                <a href="{{ route('contact') }}"
                    class="hidden rounded-full bg-orange-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-600 sm:block dark:text-black">

                    Let's Talk

                </a>

                <button id="mobile-menu-toggle" type="button" aria-label="Open navigation menu" aria-expanded="false"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 bg-gray-100 text-gray-700 transition hover:border-orange-400 hover:text-orange-500 md:hidden dark:border-white/10 dark:bg-white/5 dark:text-gray-300 dark:hover:border-orange-400 dark:hover:text-orange-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor" class="h-5 w-5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

            </div>

        </div>
    </div>

    <nav id="mobile-menu" class="hidden border-t border-gray-200 bg-white/95 px-4 py-4 shadow-lg backdrop-blur-xl md:hidden dark:border-white/10 dark:bg-[#0b0b0b]/95">
        <div class="flex flex-col gap-3">
            <a href="/" class="rounded-lg px-2 py-2 text-sm font-medium text-gray-700 transition hover:bg-orange-50 hover:text-orange-500 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-orange-400">Home</a>
            <a href="{{ route('about') }}" class="rounded-lg px-2 py-2 text-sm font-medium text-gray-700 transition hover:bg-orange-50 hover:text-orange-500 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-orange-400">About</a>
            <a href="{{ route('projects') }}" class="rounded-lg px-2 py-2 text-sm font-medium text-gray-700 transition hover:bg-orange-50 hover:text-orange-500 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-orange-400">Projects</a>
            <a href="{{ route('skills') }}" class="rounded-lg px-2 py-2 text-sm font-medium text-gray-700 transition hover:bg-orange-50 hover:text-orange-500 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-orange-400">Skills</a>
            <a href="{{ route('blog') }}" class="rounded-lg px-2 py-2 text-sm font-medium text-gray-700 transition hover:bg-orange-50 hover:text-orange-500 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-orange-400">Blog</a>
            <a href="{{ route('contact') }}" class="mt-2 inline-flex items-center justify-center rounded-full bg-orange-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-600 dark:text-black">Let's Talk</a>
        </div>
    </nav>

</header>
