<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

function db(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    try {
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );

        return $pdo;
    } catch (PDOException $e) {
        die(
            '<div style="
                font-family:Arial;
                max-width:700px;
                margin:80px auto;
                padding:30px;
                border:1px solid #ddd;
                border-radius:15px;
            ">
                <h2>Database Connection Error</h2>
                <p>Please check <strong>config/config.php</strong>.</p>
                <p>Also make sure MySQL is running and <strong>database/schema.sql</strong> has been imported.</p>
            </div>'
        );
    }
}