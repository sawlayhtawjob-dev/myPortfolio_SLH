<section
    class="section education-section"
    id="education"
>

    <div class="container">

        <div class="section-heading reveal">

            <span class="section-number">05</span>

            <div>
                <span class="section-kicker">EDUCATION</span>

                <h2>
                    Academic
                    <span>background.</span>
                </h2>
            </div>

        </div>


        <div class="education-grid">

            <?php foreach ($education as $item): ?>

                <article class="education-card reveal">

                    <span class="education-period">
                        <?= e($item['period']) ?>
                    </span>

                    <h3>
                        <?= e($item['degree']) ?>
                    </h3>

                    <p>
                        <?= e($item['institution']) ?>
                    </p>

                </article>

            <?php endforeach; ?>

        </div>

    </div>

</section>