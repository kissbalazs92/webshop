<?php

$host = "webshop-db-1";
$db = "webshop";
$user = "webshop_user";
$pass = "webshop_password";
$charset = 'utf8mb4';
$port = 3307;

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    $pdo->exec("SET NAMES utf8mb4");
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}