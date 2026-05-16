<?php
include 'database/db_connection.php';

try {
    echo "Linking book images from img/books_img...\n";
    
    $books = $pdo->query("SELECT book_id, title FROM books")->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($books as $book) {
        $title = trim($book['title']);
        $id = $book['book_id'];
        
        // Try matching with .png extension
        $image_path = "img/books_img/" . $title . ".png";
        
        if (file_exists($image_path)) {
            $stmt = $pdo->prepare("UPDATE books SET book_image = ? WHERE book_id = ?");
            $stmt->execute([$image_path, $id]);
            echo "Linked: $title -> $image_path\n";
        } else {
            echo "Image not found for: $title (Expected: $image_path)\n";
        }
    }
    
    echo "SUCCESS: All book covers are now linked.\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
