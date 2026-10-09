<header
    class="fixed left-0 right-0 top-0 z-50 border-b border-gray-200/80 bg-white/80 backdrop-blur-xl transition-colors duration-300 dark:border-white/10 dark:bg-[#0b0b0b]/80">

    <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">

        <!-- Logo -->

        <a href="{{ url('/') }}" class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">

            {{ $profile->name ?? 'RoshanGauchan' }}

        </a>


        <!-- Desktop Navigation -->

        <nav class="hidden items-center gap-8 md:flex">

            <a href="#home"
                class="text-sm text-gray-600 transition hover:text-orange-500 dark:text-gray-300 dark:hover:text-orange-400">
                Home
            </a>

            <a href="#about"
                class="text-sm text-gray-600 transition hover:text-orange-500 dark:text-gray-300 dark:hover:text-orange-400">
                About
            </a>

            <a href="#projects"
                class="text-sm text-gray-600 transition hover:text-orange-500 dark:text-gray-300 dark:hover:text-orange-400">
                Projects
            </a>

            <a href="#skills"
                class="text-sm text-gray-600 transition hover:text-orange-500 dark:text-gray-300 dark:hover:text-orange-400">
                Skills
            </a>

            <a href="#contact"
                class="text-sm text-gray-600 transition hover:text-orange-500 dark:text-gray-300 dark:hover:text-orange-400">
                Contact
            </a>

        </nav>


        <!-- Right Side -->

        <div class="flex items-center gap-3">


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

            <a href="#contact"
                class="hidden rounded-full bg-orange-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-600 sm:block dark:text-black">

                Let's Talk

            </a>

        </div>

    </div>

</header>
