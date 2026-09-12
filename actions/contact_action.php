<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';

if (!is_post()) {
    redirect();
}

verify_csrf();

$name = trim((string) post('name'));
$email = trim((string) post('email'));
$subject = trim((string) post('subject'));
$message = trim((string) post('message'));

if (
    $name === '' ||
    $message === '' ||
    !filter_var($email, FILTER_VALIDATE_EMAIL)
) {
    flash(
        'error',
        'Please enter valid contact information.'
    );

    redirect('#contact');
}

db_execute(
    "INSERT INTO messages
    (name, email, subject, message)
    VALUES (?, ?, ?, ?)",
    [
        $name,
        $email,
        $subject,
        $message
    ]
);

flash(
    'success',
    'Your message has been sent successfully.'
);

redirect('#contact');