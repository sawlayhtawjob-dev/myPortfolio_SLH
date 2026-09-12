<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';

require_admin();

if (!is_post()) {
    redirect('admin/experience.php');
}

verify_csrf();

$id = (int) post('id');

$data = [
    trim((string) post('role')),
    trim((string) post('company')),
    trim((string) post('period')),
    trim((string) post('description')),
    (int) post('sort_order', 0)
];

if ($id) {

    db_execute(
        "UPDATE experience
         SET role=?, company=?, period=?,
             description=?, sort_order=?
         WHERE id=?",
        [...$data, $id]
    );

} else {

    db_execute(
        "INSERT INTO experience
        (role, company, period, description, sort_order)
        VALUES (?, ?, ?, ?, ?)",
        $data
    );

}

redirect('admin/experience.php');