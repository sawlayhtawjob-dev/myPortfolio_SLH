<section
    class="section experience-section"
    id="experience"
>

    <div class="container">

        <div class="section-heading reveal">

            <span class="section-number">04</span>

            <div>
                <span class="section-kicker">EXPERIENCE</span>

                <h2>
                    Where I've
                    <span>grown.</span>
                </h2>
            </div>

        </div>


        <div class="timeline">

            <?php foreach ($experiences as $index => $experience): ?>

                <article class="timeline-item reveal">

                    <div class="timeline-marker">
                        <?= str_pad((string)($index + 1), 2, '0', STR_PAD_LEFT) ?>
                    </div>

                    <div class="timeline-content">

                        <div class="timeline-top">

                            <div>

                                <span class="timeline-period">
                                    <?= e($experience['period']) ?>
                                </span>

                                <h3>
                                    <?= e($experience['role']) ?>
                                </h3>

                                <strong>
                                    <?= e($experience['company']) ?>
                                </strong>

                            </div>

                        </div>

                        <div class="timeline-description">
                            <?= nl2br(e($experience['description'])) ?>
                        </div>

                    </div>

                </article>

            <?php endforeach; ?>

        </div>

    </div>

</section>