<?php
declare(strict_types=1);

require_admin();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title><?= e($pageTitle ?? 'Admin') ?></title>

    <link
        rel="stylesheet"
        href="<?= ASSET_URL ?>css/admin.css"
    >

</head>

<body>

<div class="admin-shell">

    <aside class="admin-sidebar">

        <a
            href="<?= url('admin/index.php') ?>"
            class="admin-logo"
        >
            <span>&lt;</span> SLH <span>/&gt;</span>
        </a>

        <div class="admin-user">
            <small>LOGGED IN AS</small>
            <strong>
                <?= e($_SESSION['admin_username'] ?? 'Admin') ?>
            </strong>
        </div>

        <nav class="admin-nav">

            <a href="<?= url('admin/index.php') ?>">
                Dashboard
            </a>

            <a href="<?= url('admin/profile.php') ?>">
                Profile
            </a>

            <a href="<?= url('admin/skills.php') ?>">
                Skills
            </a>

            <a href="<?= url('admin/projects.php') ?>">
                Projects
            </a>

            <a href="<?= url('admin/experience.php') ?>">
                Experience
            </a>

            <a href="<?= url('admin/education.php') ?>">
                Education
            </a>

            <a href="<?= url('admin/certifications.php') ?>">
                Certifications
            </a>

            <a href="<?= url('admin/messages.php') ?>">
                Messages
            </a>

        </nav>

        <a
            href="<?= url('admin/logout.php') ?>"
            class="admin-logout"
        >
            Logout →
        </a>

    </aside>

    <main class="admin-main">