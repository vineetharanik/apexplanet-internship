<?php
session_start();
include 'config.php';

if(isset($_POST['submit'])){
    $stmt = $conn->prepare("INSERT INTO students (name,email,phone) VALUES (:name,:email,:phone)");
    $stmt->bindValue(':name', $_POST['name']);
    $stmt->bindValue(':email', $_POST['email']);
    $stmt->bindValue(':phone', $_POST['phone']);
    $stmt->execute();

    $_SESSION['success'] = "Student added successfully!";
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Student</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f4f9;
        padding: 20px;
    }
    h2 {
        text-align: center;
        color: #6c63ff;
        margin-bottom: 20px;
    }
    form {
        width: 400px;
        margin: auto;
        background: #fff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    label {
        display: block;
        margin-top: 15px;
        font-weight: bold;
    }
    input[type="text"], input[type="email"] {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 16px;
    }
    button {
        margin-top: 20px;
        padding: 10px 15px;
        background: #6c63ff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        width: 100%;
    }
    button:hover {
        background: #5a54d1;
    }
    a.back {
        display: block;
        text-align: center;
        margin-top: 15px;
        color: #6c63ff;
        text-decoration: none;
    }
    a.back:hover {
        text-decoration: underline;
    }
    .success {
        width: 400px;
        margin: 10px auto;
        text-align: center;
        color: #00b894;
        font-weight: bold;
    }
</style>
</head>
<body>

<h2>Add New Student</h2>

<?php
if(isset($_SESSION['success'])){
    echo "<div class='success'>".$_SESSION['success']."</div>";
    unset($_SESSION['success']);
}
?>

<form method="POST">
    <label>Name:</label>
    <input type="text" name="name" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Phone:</label>
    <input type="text" name="phone" required>

    <button type="submit" name="submit">Add Student</button>
</form>

<a href="index.php" class="back">← Back to List</a>

</body>
</html>
