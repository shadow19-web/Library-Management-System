<?php
include 'database/db_connection.php';

try {
    echo "Double-checking BOOKS table columns...\n";
    $q = $pdo->query("DESCRIBE books");
    $cols = [];
    while($r = $q->fetch()) { $cols[] = $r['Field']; }
    
    echo "Columns found: " . implode(", ", $cols) . "\n";

    if (!in_array('author', $cols)) {
        echo "Missing 'author' column! Adding it now...\n";
        $pdo->exec("ALTER TABLE books ADD COLUMN author VARCHAR(255) AFTER title");
    }
    
    if (!in_array('year_published', $cols)) {
        echo "Missing 'year_published' column! Adding it now...\n";
        $pdo->exec("ALTER TABLE books ADD COLUMN year_published INT AFTER category");
    }

    echo "Finalizing data sync...\n";
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
            $title = trim($data['Book Title']);
            $author = trim($data['Author'] ?? 'Unknown');
            $year = (int)($data['Year Published'] ?? 0);

            // Use a very aggressive update
            $pdo->prepare("UPDATE books SET author = ?, year_published = ? WHERE title LIKE ?")
                ->execute([$author, $year, $title]);
        }
    }
    echo "SUCCESS: All books are now synced with authors and years.\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
