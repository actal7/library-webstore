<?php

$dsn = getenv('DATABASE_URL');

if ($dsn) {
    $url = parse_url($dsn);

    $db_host = $url['host'];
    $db_port = $url['port'];
    $db_user = $url['user'];
    $db_pass = $url['pass'];
    $db_name = ltrim($url['path'], '/');

    $pdo_dsn = "pgsql:host=$db_host;port=$db_port;dbname=$db_name";

    try {
        $pdo = new PDO($pdo_dsn, $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
} else {
    die("DATABASE_URL not set.");
}
