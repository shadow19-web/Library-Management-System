<?php
include 'database/db_connection.php';
$q = $pdo->query("SELECT title, author, year_published FROM books");
while($r = $q->fetch()) {
    echo "[" . $r['title'] . "] | Author: [" . $r['author'] . "] | Year: [" . $r['year_published'] . "]\n";
}
