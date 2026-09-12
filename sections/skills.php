<section
    class="section skills-section"
    id="skills"
>

    <div class="container">

        <div class="section-heading reveal">

            <span class="section-number">02</span>

            <div>
                <span class="section-kicker">TECH STACK</span>

                <h2>
                    Tools I use to
                    <span>build.</span>
                </h2>
            </div>

        </div>


        <?php
        $skillGroups = [];

        foreach ($skills as $skill) {
            $skillGroups[$skill['category']][] = $skill;
        }
        ?>


        <div class="skills-groups">

            <?php foreach ($skillGroups as $category => $items): ?>

                <div class="skill-group reveal">

                    <div class="skill-group-title">
                        <?= e($category) ?>
                    </div>

                    <div class="skill-list">

                        <?php foreach ($items as $skill): ?>

                            <div class="skill-chip">

                                <span class="skill-icon">
                                    <?= strtoupper(substr($skill['name'], 0, 1)) ?>
                                </span>

                                <span>
                                    <?= e($skill['name']) ?>
                                </span>

                            </div>

                        <?php endforeach; ?>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

</section>