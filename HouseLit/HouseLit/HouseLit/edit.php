<?php
session_start();
include 'config.php';
if(!isset($_SESSION['user_id']) || !in_array($_SESSION['user_role'], ['admin','editor'])){
    die("❌ Unauthorized access.");
}

$id = (int)$_GET['id'];
$stmt = $conn->prepare("SELECT * FROM students WHERE id=:id");
$stmt->bindValue(':id',$id,PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['submit'])){
    $stmt = $conn->prepare("UPDATE students SET name=:name,email=:email,phone=:phone WHERE id=:id");
    $stmt->bindValue(':name', $_POST['name']);
    $stmt->bindValue(':email', $_POST['email']);
    $stmt->bindValue(':phone', $_POST['phone']);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Student</title>
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
    }
    button:hover {
        background: #5a54d1;
    }
    a.back {
        display: inline-block;
        margin-top: 15px;
        color: #6c63ff;
        text-decoration: none;
    }
    a.back:hover {
        text-decoration: underline;
    }
</style>
</head>
<body>

<h2>Edit Student</h2>

<form method="POST">
    <label>Name:</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>

    <label>Phone:</label>
    <input type="text" name="phone" value="<?php echo htmlspecialchars($row['phone']); ?>" required>

    <button type="submit" name="submit">Update Student</button>
    <a href="index.php" class="back">← Back to List</a>
</form>

</body>
</html>
