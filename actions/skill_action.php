<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';

require_admin();

if (!is_post()) {
    redirect('admin/skills.php');
}

verify_csrf();

$id = (int) post('id');

$data = [
    trim((string) post('name')),
    trim((string) post('category')),
    trim((string) post('icon')),
    (int) post('sort_order', 0)
];

if ($id) {

    db_execute(
        "UPDATE skills
         SET name=?, category=?, icon=?, sort_order=?
         WHERE id=?",
        [...$data, $id]
    );

} else {

    db_execute(
        "INSERT INTO skills
        (name, category, icon, sort_order)
        VALUES (?, ?, ?, ?)",
        $data
    );
}

redirect('admin/skills.php');