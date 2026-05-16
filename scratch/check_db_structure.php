<?php
include 'database/db_connection.php';
echo "--- BOOKS TABLE ---\n";
$q = $pdo->query("DESCRIBE books");
while($r = $q->fetch()) { echo $r['Field'] . " (" . $r['Type'] . ")\n"; }

echo "\n--- BORROWINGS TABLE ---\n";
try {
    $q = $pdo->query("DESCRIBE borrowings");
    while($r = $q->fetch()) { echo $r['Field'] . " (" . $r['Type'] . ")\n"; }
} catch (Exception $e) {
    echo "borrowings table not found.\n";
}
