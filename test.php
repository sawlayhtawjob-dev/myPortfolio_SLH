<?php

echo "PHP OK<br>";

echo "Before DB<br>";

$pdo = new PDO(
    'mysql:host=127.0.0.1;dbname=myPortfolio_SLH;charset=utf8mb4',
    'root',
    '',
    array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 5
    )
);

echo "DB OK<br>";