<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ optional($profile)->name ?? 'RoshanGauchan' }} | Portfolio</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Prevent flash of wrong theme -->
    <script>
        if (
            localStorage.theme === 'light' ||
            (!('theme' in localStorage) &&
                !window.matchMedia('(prefers-color-scheme: dark)').matches)
        ) {
            document.documentElement.classList.remove('dark');
        } else {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>


<body>

    <x-header />
    <main class="bg-white text-gray-900 transition-colors duration-300 dark:bg-[#0b0b0b] dark:text-white">
        @yield('content')
    </main>
    <x-footer />


    @stack('script')

    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const sunIcon = document.getElementById('sun-icon');
        const moonIcon = document.getElementById('moon-icon');
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        function updateThemeIcon() {
            if (!sunIcon || !moonIcon) return;

            if (document.documentElement.classList.contains('dark')) {
                moonIcon.classList.remove('hidden');
                sunIcon.classList.add('hidden');
            } else {
                moonIcon.classList.add('hidden');
                sunIcon.classList.remove('hidden');
            }
        }

        if (themeToggle) {
            themeToggle.addEventListener('click', function() {
                const isDark = document.documentElement.classList.toggle('dark');

                if (isDark) {
                    localStorage.theme = 'dark';
                } else {
                    localStorage.theme = 'light';
                }

                updateThemeIcon();
            });
        }

        if (mobileMenuToggle && mobileMenu) {
            mobileMenuToggle.addEventListener('click', function() {
                const isExpanded = mobileMenu.classList.toggle('hidden');
                mobileMenuToggle.setAttribute('aria-expanded', String(!isExpanded));
            });

            mobileMenu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenu.classList.add('hidden');
                    mobileMenuToggle.setAttribute('aria-expanded', 'false');
                });
            });
        }

        updateThemeIcon();
    </script>


</body>



</html>
