<?php
session_start();
include 'config.php';

// === Auto-create admin if no users exist ===
$stmt = $conn->query("SELECT COUNT(*) AS total FROM users");
$totalUsers = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

if($totalUsers == 0){
    // Password hash for admin123
    $hashed = password_hash("admin123", PASSWORD_DEFAULT);
    $conn->exec("INSERT INTO users (username, password, role) VALUES ('admin', '$hashed', 'admin')");
}

$error = "";

if(isset($_POST['login'])){
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=:username");
    $stmt->bindValue(':username', $_POST['username']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user && password_verify($_POST['password'], $user['password'])){
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_role'] = $user['role'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<style>
body { font-family: Arial; text-align:center; padding:50px; background:#f4f4f9; }
form { display:inline-block; padding:20px; background:#fff; border-radius:10px; }
input { margin:10px; padding:10px; width:200px; }
button { padding:10px 20px; background:#6c63ff; color:white; border:none; border-radius:5px; cursor:pointer; }
p.error { color:red; font-weight:bold; }
</style>
</head>
<body>

<h2>Login</h2>
<form method="POST">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit" name="login">Login</button>
</form>
<?php if($error) echo "<p class='error'>$error</p>"; ?>
</body>
</html>
