<?php
include 'database/db_connection.php';

$content = file_get_contents('book_info');
$blocks = explode("\n\n", trim($content));

echo "Importing books from book_info...\n";

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
        $author = $data['Author'] ?? 'Unknown Author';
        $desc = $data['Description'] ?? '';
        $cat_name = $data['Category'] ?? 'General';
        $year = $data['Year Published'] ?? date('Y');
        $isbn = strtoupper(substr(md5($title), 0, 13)); // Generate dummy ISBN

        try {
            // 1. Ensure Category exists
            $cat_stmt = $pdo->prepare("INSERT IGNORE INTO categories (category_name) VALUES (?)");
            $cat_stmt->execute([$cat_name]);
            
            // 2. Ensure Author exists
            $auth_stmt = $pdo->prepare("INSERT IGNORE INTO authors (author_name) VALUES (?)");
            $auth_stmt->execute([$author]);
            $author_id = $pdo->query("SELECT author_id FROM authors WHERE author_name = " . $pdo->quote($author))->fetchColumn();

            // 3. Insert Book
            $book_stmt = $pdo->prepare("INSERT IGNORE INTO books (title, isbn, category, quantity, available_copies, description, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
            // Also need to handle status and year if we had columns for them
            $book_stmt->execute([
                $title, 
                $isbn, 
                $cat_name, 
                10, // Default 10 copies
                10, 
                $desc,
                "$year-01-01 00:00:00"
            ]);
            $book_id = $pdo->lastInsertId();

            if ($book_id) {
                // 4. Link Author
                $pdo->prepare("INSERT IGNORE INTO book_authors (book_id, author_id) VALUES (?, ?)")->execute([$book_id, $author_id]);
                echo "Imported: $title\n";
            } else {
                echo "Skipped (Already exists): $title\n";
            }

        } catch (Exception $e) {
            echo "Error importing $title: " . $e->getMessage() . "\n";
        }
    }
}

echo "DONE: Library is now populated.\n";
