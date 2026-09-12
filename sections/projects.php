<section
    class="section projects-section"
    id="projects"
>

    <div class="container">

        <div class="section-heading reveal">

            <span class="section-number">03</span>

            <div>
                <span class="section-kicker">SELECTED PROJECTS</span>

                <h2>
                    Things I've
                    <span>worked on.</span>
                </h2>
            </div>

        </div>


        <div class="projects-grid">

            <?php foreach ($projects as $index => $project): ?>

                <article
                    class="project-card reveal"
                    style="--delay: <?= $index * 0.08 ?>s"
                >

                    <div class="project-number">
                        <?= str_pad((string)($index + 1), 2, '0', STR_PAD_LEFT) ?>
                    </div>

                    <div class="project-content">

                        <span class="project-category">
                            <?= e($project['category']) ?>
                        </span>

                        <h3>
                            <?= e($project['title']) ?>
                        </h3>

                        <p>
                            <?= nl2br(e($project['description'])) ?>
                        </p>

                        <div class="project-tech">

                            <?php
                            $techs = array_filter(
                                array_map(
                                    'trim',
                                    explode(',', $project['technologies'])
                                )
                            );
                            ?>

                            <?php foreach ($techs as $tech): ?>

                                <span>
                                    <?= e($tech) ?>
                                </span>

                            <?php endforeach; ?>

                        </div>

                    </div>


                    <div class="project-footer">

                        <?php if (!empty($project['url'])): ?>

                            <a
                                href="<?= e($project['url']) ?>"
                                target="_blank"
                                rel="noopener"
                                class="project-link"
                            >
                                Visit Project
                                <span>↗</span>
                            </a>

                        <?php else: ?>

                            <span class="project-link muted">
                                Internal Project
                            </span>

                        <?php endif; ?>

                    </div>

                </article>

            <?php endforeach; ?>

        </div>

    </div>

</section>