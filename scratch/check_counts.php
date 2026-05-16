<?php
include 'database/db_connection.php';
echo "Total Books in DB: " . $pdo->query("SELECT COUNT(*) FROM books")->fetchColumn() . "\n";
echo "Total Borrowings in DB: " . $pdo->query("SELECT COUNT(*) FROM borrowings")->fetchColumn() . "\n";
echo "Total Users in DB: " . $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn() . "\n";
