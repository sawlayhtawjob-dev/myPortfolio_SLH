<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';

require_admin();

if (!is_post()) {
    redirect('admin/education.php');
}

verify_csrf();

$id = (int) post('id');

$data = [
    trim((string) post('degree')),
    trim((string) post('institution')),
    trim((string) post('period')),
    trim((string) post('description')),
    (int) post('sort_order', 0)
];

if ($id) {

    db_execute(
        "UPDATE education
         SET degree=?, institution=?, period=?,
             description=?, sort_order=?
         WHERE id=?",
        [...$data, $id]
    );

} else {

    db_execute(
        "INSERT INTO education
        (degree, institution, period, description, sort_order)
        VALUES (?, ?, ?, ?, ?)",
        $data
    );

}

redirect('admin/education.php');