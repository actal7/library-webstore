<?php
// index.php

echo "Hello, Worldss!";

// Database connection
$dsn = getenv('DATABASE_URL');
// $dsn = "postgres://ufr3el9qeuqndc:paa0ff9e2ed6b092fd720110ec3f661c044c9dbaf9a25737e0a6c22090ed67c37@cat670aihdrkt1.cluster-czrs8kj4isg7.us-east-1.rds.amazonaws.com:5432/d6i7lntq2t1c5t";

echo "<p>Database URL: $dsn</p>";

if ($dsn) {
    // Parse the URL
    $url = parse_url($dsn);

    // Construct the DSN for PDO
    $db_host = $url['host'];
    $db_port = $url['port'];
    $db_user = $url['user'];
    $db_pass = $url['pass'];
    $db_name = ltrim($url['path'], '/');

    $pdo_dsn = "pgsql:host=$db_host;port=$db_port;dbname=$db_name";
    
    try {
        $pdo = new PDO($pdo_dsn, $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "<p>Connected to the database successfully!</p>";
    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>DATABASE_URL not set.</p>";
}
?>
