<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';

require_admin();

if (!is_post()) {
    redirect('admin/profile.php');
}

verify_csrf();

$id = (int) post('id');

db_execute(
    "UPDATE profile SET
        full_name=?,
        role=?,
        summary=?,
        phone=?,
        email=?,
        location=?,
        portfolio_url=?,
        github_url=?
     WHERE id=?",
    [
        trim((string) post('full_name')),
        trim((string) post('role')),
        trim((string) post('summary')),
        trim((string) post('phone')),
        trim((string) post('email')),
        trim((string) post('location')),
        trim((string) post('portfolio_url')),
        trim((string) post('github_url')),
        $id
    ]
);

flash(
    'success',
    'Profile updated.'
);

redirect('admin/profile.php');