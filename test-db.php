<?php

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

try {
    $pdo = db();
    echo "Database OK";
} catch (Throwable $e) {
    echo "Database ERROR: " . $e->getMessage();
}