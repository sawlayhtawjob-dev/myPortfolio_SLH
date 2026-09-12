<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';

require_admin();

$pageTitle = 'Admin Dashboard';

$stats = [
    'projects' => (int) db_one(
        "SELECT COUNT(*) AS total FROM projects"
    )['total'],

    'skills' => (int) db_one(
        "SELECT COUNT(*) AS total FROM skills"
    )['total'],

    'experience' => (int) db_one(
        "SELECT COUNT(*) AS total FROM experience"
    )['total'],

    'messages' => (int) db_one(
        "SELECT COUNT(*) AS total FROM messages"
    )['total'],

    'unread' => (int) db_one(
        "SELECT COUNT(*) AS total FROM messages WHERE is_read = 0"
    )['total'],
];

require_once __DIR__ . '/layout.php';
?>

<div class="admin-content">

    <div class="admin-page-head">

        <div>
            <span>OVERVIEW</span>
            <h1>Dashboard</h1>
        </div>

        <a
            href="<?= url() ?>"
            target="_blank"
            class="admin-btn secondary"
        >
            View Portfolio ↗
        </a>

    </div>


    <div class="dashboard-grid">

        <div class="dashboard-card">
            <span>Projects</span>
            <strong><?= $stats['projects'] ?></strong>
        </div>

        <div class="dashboard-card">
            <span>Skills</span>
            <strong><?= $stats['skills'] ?></strong>
        </div>

        <div class="dashboard-card">
            <span>Experience</span>
            <strong><?= $stats['experience'] ?></strong>
        </div>

        <div class="dashboard-card">
            <span>Messages</span>
            <strong><?= $stats['messages'] ?></strong>

            <?php if ($stats['unread']): ?>
                <small>
                    <?= $stats['unread'] ?> unread
                </small>
            <?php endif; ?>

        </div>

    </div>


    <div class="admin-welcome">

        <span class="admin-badge">SYSTEM READY</span>

        <h2>
            Manage your portfolio
            without touching index.php.
        </h2>

        <p>
            Update profile, skills, projects,
            experience, education and certifications
            directly from the dashboard.
        </p>

    </div>

</div>

</div>
</body>
</html>