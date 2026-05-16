<?php
include 'database/db_connection.php';
include 'helpers/cryptography_process.php';

$stmt = $pdo->query("SELECT user_id, username, phone_number FROM users ORDER BY user_id DESC LIMIT 1");
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo "Last User ID: " . $user['user_id'] . "\n";
    echo "Username: " . $user['username'] . "\n";
    echo "Phone in DB: " . $user['phone_number'] . "\n";
    echo "Decrypted: " . decryptionData($user['phone_number']) . "\n";
} else {
    echo "No users found.\n";
}
