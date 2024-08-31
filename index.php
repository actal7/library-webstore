<?php
// index.php

echo "Hello, World!";

// Database connection
$dsn = getenv('DATABASE_URL');
if ($dsn) {
    $dsn = preg_replace('/^postgres:/', 'pgsql:', $dsn);
    try {
        $pdo = new PDO($dsn);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "<p>Connected to the database successfully!</p>";
    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>DATABASE_URL not set.</p>";
}
?>
