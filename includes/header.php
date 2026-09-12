<?php
declare(strict_types=1);

require_once __DIR__ . '/functions.php';

$pageTitle = $pageTitle ?? SITE_NAME;
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="SAWLAYHTAW — Web Developer / Full-Stack Developer"
    >

    <title><?= e($pageTitle) ?></title>

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="<?= ASSET_URL ?>css/style.css"
    >

    <link
        rel="stylesheet"
        href="<?= ASSET_URL ?>css/responsive.css"
    >

    <link
        rel="stylesheet"
        href="<?= ASSET_URL ?>css/animations.css"
    >
    <link
        rel="icon"
        type="image/svg+xml"
        href="<?= e(url('assets/images/favicon.svg')) ?>"
    >

</head>

<body>

<div class="page-loader">
    <div class="loader-inner">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>

<div class="page-transition"></div>