<?php
require_once 'helpers/cryptography_process.php';
require_once 'database/db_connection.php';

echo "Testing decryption of users in DB...\n";

try {
    $stmt = $pdo->query("SELECT username, phone_number FROM users LIMIT 5");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $decrypted = decryptionData($row['phone_number']);
        echo "User: {$row['username']}\n";
        echo "Encrypted: {$row['phone_number']}\n";
        echo "Decrypted: " . ($decrypted === false ? "[FAILED]" : $decrypted) . "\n";
        echo "-------------------\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
