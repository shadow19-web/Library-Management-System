<?php
include 'database/db_connection.php';

try {
    $pdo->exec("ALTER TABLE users MODIFY phone_number VARCHAR(100)");
    $pdo->exec("ALTER TABLE users MODIFY username VARCHAR(100)");
    $pdo->exec("ALTER TABLE users MODIFY first_name VARCHAR(100)");
    $pdo->exec("ALTER TABLE users MODIFY last_name VARCHAR(100)");
    echo "Database columns successfully expanded to 100 characters!\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
