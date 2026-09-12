<section class="section certification-section">

    <div class="container">

        <div class="section-heading reveal">

            <span class="section-number">06</span>

            <div>
                <span class="section-kicker">CERTIFICATIONS</span>

                <h2>
                    Credentials &
                    <span>certifications.</span>
                </h2>
            </div>

        </div>


        <div class="certification-grid">

            <?php foreach ($certifications as $cert): ?>

                <article class="cert-card reveal">

                    <div class="cert-icon">
                        ✓
                    </div>

                    <div>

                        <span>
                            <?= e($cert['certification_date']) ?>
                        </span>

                        <h3>
                            <?= e($cert['name']) ?>
                        </h3>

                        <p>
                            <?= e($cert['issuer']) ?>
                        </p>

                    </div>

                </article>

            <?php endforeach; ?>

        </div>

    </div>

</section>