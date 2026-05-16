<?php
include 'database/db_connection.php';
echo "--- ALL TABLES ---\n";
$q = $pdo->query("SHOW TABLES");
while($r = $q->fetch()) { 
    $table = $r[0];
    $count = $pdo->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
    echo "$table ($count rows)\n";
}
