<?php
include 'database/db_connection.php';

try {
    echo "Adding missing columns to BOOKS table...\n";
    // 1. Add author column
    $pdo->exec("ALTER TABLE books ADD COLUMN IF NOT EXISTS author VARCHAR(255) AFTER title");
    
    // 2. Add year_published column
    $pdo->exec("ALTER TABLE books ADD COLUMN IF NOT EXISTS year_published INT AFTER category");
    
    // 3. Add book_image column
    $pdo->exec("ALTER TABLE books ADD COLUMN IF NOT EXISTS book_image VARCHAR(255) AFTER status");

    echo "Syncing data from book_info...\n";
    
    // Parse book_info again to fill these specific columns
    $content = file_get_contents('book_info');
    $blocks = explode("\n\n", trim($content));

    foreach ($blocks as $block) {
        $lines = explode("\n", $block);
        $data = [];
        foreach ($lines as $line) {
            if (strpos($line, ': ') !== false) {
                list($key, $val) = explode(': ', $line, 2);
                $data[trim($key)] = trim($val);
            }
        }

        if (isset($data['Book Title'])) {
            $title = $data['Book Title'];
            $author = $data['Author'] ?? '';
            $year = (int)($data['Year Published'] ?? 0);

            $stmt = $pdo->prepare("UPDATE books SET author = ?, year_published = ? WHERE title = ?");
            $stmt->execute([$author, $year, $title]);
            echo "Updated: $title ($author, $year)\n";
        }
    }

    echo "SUCCESS: Librarian Dashboard should now show all book info correctly.\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
