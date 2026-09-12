<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';

require_admin();

if (!is_post()) {
    redirect('admin/certifications.php');
}

verify_csrf();

$id = (int) post('id');

$data = [
    trim((string) post('name')),
    trim((string) post('issuer')),
    trim((string) post('certification_date')),
    trim((string) post('credential_url')),
    (int) post('sort_order', 0)
];

if ($id) {

    db_execute(
        "UPDATE certifications
         SET name=?, issuer=?, certification_date=?,
             credential_url=?, sort_order=?
         WHERE id=?",
        [...$data, $id]
    );

} else {

    db_execute(
        "INSERT INTO certifications
        (name, issuer, certification_date,
         credential_url, sort_order)
        VALUES (?, ?, ?, ?, ?)",
        $data
    );

}

redirect('admin/certifications.php');