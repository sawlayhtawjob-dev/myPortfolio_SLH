<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'SAWLAYHTAW — Web Developer / Full-Stack Developer';

$profile = db_one(
    "SELECT * FROM profile ORDER BY id ASC LIMIT 1"
);

$skills = db_all(
    "SELECT * FROM skills ORDER BY sort_order ASC, id ASC"
);

$projects = db_all(
    "SELECT * FROM projects ORDER BY sort_order ASC, id ASC"
);

$experiences = db_all(
    "SELECT * FROM experience ORDER BY sort_order ASC, id ASC"
);

$education = db_all(
    "SELECT * FROM education ORDER BY sort_order ASC, id ASC"
);

$certifications = db_all(
    "SELECT * FROM certifications ORDER BY sort_order ASC, id ASC"
);

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';

require_once __DIR__ . '/sections/hero.php';
require_once __DIR__ . '/sections/about.php';
require_once __DIR__ . '/sections/skills.php';
require_once __DIR__ . '/sections/projects.php';
require_once __DIR__ . '/sections/experience.php';
require_once __DIR__ . '/sections/education.php';
require_once __DIR__ . '/sections/certifications.php';
require_once __DIR__ . '/sections/contact.php';

require_once __DIR__ . '/includes/footer.php';