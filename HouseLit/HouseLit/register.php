<?php
session_start();
include 'config.php';

$message = "";

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = "user"; // outsiders will be normal users

    // Check if username already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindValue(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $message = "❌ Username already taken!";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', $hashedPassword);
        $stmt->bindValue(':role', $role);
        $stmt->execute();

        $message = "✅ Registration successful! You can now <a href='login.php'>login</a>.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<style>
body { font-family: Arial; background:#f4f4f9; text-align:center; padding:50px; }
form { display:inline-block; background:#fff; padding:30px; border-radius:10px; }
input { margin:10px; padding:10px; width:220px; }
button { background:#6c63ff; color:#fff; border:none; padding:10px 20px; border-radius:5px; cursor:pointer; }
p { font-weight:bold; }
a { color:#6c63ff; text-decoration:none; }
</style>
</head>
<body>

<h2>Register New User</h2>
<form method="POST">
    <input type="text" name="username" placeholder="Enter username" required><br>
    <input type="password" name="password" placeholder="Enter password" required><br>
    <button type="submit" name="register">Register</button>
</form>

<p><?php echo $message; ?></p>
<p>Already have an account? <a href="login.php">Login here</a></p>

</body>
</html>
