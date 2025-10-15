<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$server = "localhost";
$username = "root";
$password = "";
$dbname = "students_db"; // your database name             // control panel password of this new account

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Database connection successful!";
} catch (PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage();
}
?>
