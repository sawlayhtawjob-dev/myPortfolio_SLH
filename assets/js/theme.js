(function () {

    const root = document.documentElement;
    const toggle = document.getElementById('themeToggle');

    const savedTheme = localStorage.getItem('slh-theme');

    if (savedTheme) {
        root.setAttribute('data-theme', savedTheme);
    } else {
        const prefersDark =
            window.matchMedia &&
            window.matchMedia('(prefers-color-scheme: dark)').matches;

        if (prefersDark) {
            root.setAttribute('data-theme', 'dark');
        }
    }

    function updateIcon() {

        if (!toggle) {
            return;
        }

        const isDark =
            root.getAttribute('data-theme') === 'dark';

        const icon =
            toggle.querySelector('.theme-icon');

        if (icon) {
            icon.textContent = isDark ? '☾' : '☼';
        }
    }

    updateIcon();

    if (toggle) {

        toggle.addEventListener('click', function () {

            const isDark =
                root.getAttribute('data-theme') === 'dark';

            const newTheme =
                isDark ? 'light' : 'dark';

            root.setAttribute(
                'data-theme',
                newTheme
            );

            localStorage.setItem(
                'slh-theme',
                newTheme
            );

            updateIcon();

        });

    }

})();