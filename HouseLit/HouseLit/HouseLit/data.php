<?php
include 'config.php';

if(isset($_GET['data'])){
    $id = (int) $_GET['data']; // Ensure it's an integer

    // Prepare PDO statement
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($row){
        // Safe output
        echo "<h2>Hello, " . htmlspecialchars($row['name']) . "</h2>";

        // Return JSON safely
        echo json_encode($row);
    } else {
        echo "<h2>No student found with ID: $id</h2>";
    }
} else {
    echo "<h2>No student ID provided</h2>";
}
?>
