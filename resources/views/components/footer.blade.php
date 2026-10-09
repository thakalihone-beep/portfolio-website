<footer class="border-t border-gray-200 bg-white transition-colors duration-300 dark:border-white/10 dark:bg-[#0b0b0b]">

    <div class="mx-auto flex max-w-7xl flex-col gap-5 px-6 py-8 md:flex-row md:items-center md:justify-between">


        <p class="text-sm text-gray-500 dark:text-gray-300">

            © {{ date('Y') }}

            {{ $profile->name ?? 'RoshanGauchan' }}.

            All rights reserved.

        </p>


        <div class="flex gap-6">

            <a href="#" class="text-sm text-gray-500 transition hover:text-orange-500 dark:text-gray-300">
                GitHub
            </a>

            <a href="#" class="text-sm text-gray-500 transition hover:text-orange-500 dark:text-gray-300">
                LinkedIn
            </a>

            <a href="#" class="text-sm text-gray-500 transition hover:text-orange-500 dark:text-gray-300">
                Instagram
            </a>

            <a href="mailto:your@email.com" class="text-sm text-gray-500 transition hover:text-orange-500 dark:text-gray-300">
                Email
            </a>

        </div>

    </div>

</footer>
