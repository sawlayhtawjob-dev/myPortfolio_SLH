<section class="hero section">

    <div class="hero-grid"></div>

    <div class="container hero-inner">

        <div class="hero-content reveal">

            <div class="eyebrow">
                <span class="status-dot"></span>
                Available for opportunities
            </div>

            <h1 class="hero-title">

                <span class="hero-line">WEB</span>

                <span class="hero-line accent">
                    DEVELOPER
                </span>

                <span class="hero-line small">
                    / FULL-STACK
                </span>

            </h1>

            <p class="hero-description">
                <?= e($profile['summary'] ?? '') ?>
            </p>

            <div class="hero-buttons">

                <a
                    href="<?= url() ?>#projects"
                    class="btn btn-primary"
                >
                    View Projects
                    <span>↗</span>
                </a>

                <a
                    href="<?= url() ?>#contact"
                    class="btn btn-outline"
                >
                    Contact Me
                </a>

                <a
                    href="<?= url($profile['cv_file'] ?? 'assets/cv/cv.pdf') ?>"
                    class="btn btn-ghost"
                    target="_blank"
                >
                    Download CV
                </a>

            </div>

            <div class="hero-meta">

                <div>
                    <strong>2026</strong>
                    <span>Freelance</span>
                </div>

                <div>
                    <strong>PHP</strong>
                    <span>Core Stack</span>
                </div>

                <div>
                    <strong>ITPEC</strong>
                    <span>Certified</span>
                </div>

            </div>

        </div>
        <div class="hero-profile reveal">

            <div class="profile-orbit orbit-one"></div>
            <div class="profile-orbit orbit-two"></div>

            <div class="profile-card">

                <div class="profile-card-top">
                    <span>01</span>
                    <span>DEVELOPER</span>
                </div>

                <div class="profile-image-wrap">

                    <img
                        src="<?= e(
                            url(
                                $profile['profile_image']
                                ?: 'assets/images/profile.jpg'
                            )
                        ) ?>?v=<?= e(
                            (string) (
                                $profile['updated_at']
                                ?? time()
                            )
                        ) ?>"
                        alt="<?= e($profile['full_name']) ?>"
                    >

                    <!-- <div class="profile-placeholder">
                        YOUR PHOTO
                    </div> -->

                </div>

                <div class="profile-card-bottom">

                    <div>
                        <strong><?= e($profile['full_name'] ?? 'SAWLAYHTAW') ?></strong>
                        <span><?= e($profile['role'] ?? '') ?></span>
                    </div>

                    <span class="profile-arrow">↗</span>

                </div>

            </div>

        </div>

    </div>

</section>