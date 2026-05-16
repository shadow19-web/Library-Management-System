<?php
include 'database/db_connection.php';

try {
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
            $author = trim($data['Author'] ?? '');
            $year = (int)($data['Year Published'] ?? 0);

            // Update using LIKE and TRIM to be safe
            $stmt = $pdo->prepare("UPDATE books SET author = ?, year_published = ? WHERE TRIM(title) = ?");
            $stmt->execute([$author, $year, $title]);
            
            if ($stmt->rowCount() > 0) {
                echo "Fixed: $title\n";
            } else {
                echo "Title not found in DB: '$title'\n";
            }
        }
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
