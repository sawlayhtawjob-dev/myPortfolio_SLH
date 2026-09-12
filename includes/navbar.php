<header class="site-header">

    <div class="container nav-container">

        <a href="<?= url() ?>" class="logo">
            <span>&lt;</span>
            SLH
            <span>/&gt;</span>
        </a>

        <nav class="main-nav" id="mainNav">

            <a href="<?= url() ?>#about">About</a>
            <a href="<?= url() ?>#skills">Skills</a>
            <a href="<?= url() ?>#projects">Projects</a>
            <a href="<?= url() ?>#experience">Experience</a>
            <a href="<?= url() ?>#education">Education</a>
            <a href="<?= url() ?>#contact">Contact</a>

        </nav>

        <div class="nav-actions">

            <button
                class="theme-toggle"
                id="themeToggle"
                type="button"
                aria-label="Toggle theme"
            >
                <span class="theme-icon">☼</span>
            </button>

            <button
                class="menu-toggle"
                id="menuToggle"
                type="button"
                aria-label="Open menu"
            >
                <span></span>
                <span></span>
                <span></span>
            </button>

        </div>

    </div>

</header>