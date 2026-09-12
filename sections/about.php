<section
    class="section about-section"
    id="about"
>

    <div class="container">

        <div class="section-heading reveal">

            <span class="section-number">01</span>

            <div>
                <span class="section-kicker">ABOUT ME</span>

                <h2>
                    Building digital experiences
                    <span>with purpose.</span>
                </h2>
            </div>

        </div>


        <div class="about-grid">

            <div class="about-copy reveal">

                <p class="large-text">
                    I'm <?= e($profile['full_name'] ?? '') ?>,
                    a <?= e($profile['role'] ?? '') ?>
                    focused on building responsive,
                    scalable and practical web solutions.
                </p>

                <p>
                    My experience covers end-to-end web development,
                    custom WordPress solutions, PHP, ReactJS,
                    PSD-to-Web responsive implementation,
                    CMS data migration and cross-platform testing.
                </p>

                <p>
                    Currently, I work as a Freelance Web Developer,
                    building database-driven web applications and
                    custom CMS solutions with a focus on practical,
                    maintainable web systems.
                </p>

            </div>


            <div class="about-info reveal">

                <div class="info-row">
                    <span>Location</span>
                    <strong><?= e($profile['location'] ?? '') ?></strong>
                </div>

                <div class="info-row">
                    <span>Email</span>
                    <a href="mailto:<?= e($profile['email'] ?? '') ?>">
                        <?= e($profile['email'] ?? '') ?>
                    </a>
                </div>

                <div class="info-row">
                    <span>Phone</span>
                    <a href="tel:<?= e($profile['phone'] ?? '') ?>">
                        <?= e($profile['phone'] ?? '') ?>
                    </a>
                </div>

                <div class="info-row">
                    <span>Portfolio</span>
                    <a
                        href="<?= e($profile['portfolio_url'] ?? '') ?>"
                        target="_blank"
                        rel="noopener"
                    >
                        Portfolio ↗
                    </a>
                </div>

                <div class="info-row">
                    <span>GitHub</span>
                    <a
                        href="<?= e($profile['github_url'] ?? '') ?>"
                        target="_blank"
                        rel="noopener"
                    >
                        GitHub ↗
                    </a>
                </div>

            </div>

        </div>

    </div>

</section>