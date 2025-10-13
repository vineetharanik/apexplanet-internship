<?php
include 'config.php';

try {
    $stmt = $conn->query("SELECT * FROM users");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($rows);
} catch(PDOException $e){
    echo "Error: " . $e->getMessage();
}
?>
