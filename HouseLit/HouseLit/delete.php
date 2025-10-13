<?php
session_start();
include 'config.php';
if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin'){
    die("❌ Unauthorized access.");
}

$id = (int)$_GET['id'];
$stmt = $conn->prepare("DELETE FROM students WHERE id=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();

header("Location: index.php");
exit;
