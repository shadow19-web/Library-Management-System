<?php
include 'database/db_connection.php';

try {
    echo "Updating BORROWINGS table...\n";
    // 1. Rename record_id to id
    $pdo->exec("ALTER TABLE borrowings CHANGE COLUMN record_id id INT AUTO_INCREMENT");
    
    // 2. Add quantity column
    $pdo->exec("ALTER TABLE borrowings ADD COLUMN IF NOT EXISTS quantity INT DEFAULT 1 AFTER book_id");
    
    // 3. Update status ENUM to include all needed types
    $pdo->exec("ALTER TABLE borrowings MODIFY COLUMN status ENUM('pending', 'approved', 'borrowed', 'returned', 'overdue', 'rejected', 'Borrowed', 'Returned', 'Overdue') DEFAULT 'pending'");
    
    // 4. Add created_at
    $pdo->exec("ALTER TABLE borrowings ADD COLUMN IF NOT EXISTS created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");

    echo "Updating BOOKS table...\n";
    // 5. Add available_copies (or rename)
    $pdo->exec("ALTER TABLE books CHANGE COLUMN available_quantity available_copies INT DEFAULT 0");
    
    // 6. Ensure category column exists (some code uses b.category directly)
    // We should probably add a virtual column or just a regular one if the code doesn't use categories table
    $pdo->exec("ALTER TABLE books ADD COLUMN IF NOT EXISTS category VARCHAR(100) AFTER isbn");

    echo "SUCCESS: Database structure now matches website code.\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
