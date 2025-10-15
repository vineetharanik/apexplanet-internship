<?php
include 'config.php';

$results = [];

if(isset($_POST['submit'])){
    $search = trim($_POST['search']); // remove extra spaces

    // Prepare SQL with placeholders
    $stmt = $conn->prepare("SELECT * FROM students 
                            WHERE name LIKE :search 
                               OR email LIKE :search 
                               OR phone LIKE :search");

    // Bind value safely with wildcards
    $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);

    // Execute query
    $stmt->execute();

    // Fetch all matching records
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Search Data</title>
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
        text-align: center;
        margin-bottom: 30px;
    }
    input[type="text"] {
        padding: 10px;
        width: 300px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 16px;
    }
    button {
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
    table {
        border-collapse: collapse;
        width: 80%;
        margin: auto;
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    th, td {
        padding: 12px 20px;
        text-align: left;
    }
    th {
        background: #6c63ff;
        color: white;
    }
    tr:nth-child(even) {
        background: #f2f2f2;
    }
    a.edit, a.delete {
        padding: 6px 12px;
        margin: 2px;
        border-radius: 5px;
        color: white;
        text-decoration: none;
        font-size: 14px;
    }
    a.edit {
        background: #00b894;
    }
    a.edit:hover {
        background: #019874;
    }
    a.delete {
        background: #d63031;
    }
    a.delete:hover {
        background: #c12a27;
    }
    td a {
        display: inline-block;
    }
    .no-results {
        text-align: center;
        padding: 15px;
        font-style: italic;
        color: #555;
    }
</style>
</head>
<body>

<h2>Search Students</h2>

<form method="POST" action="search.php">
    <input type="text" name="search" placeholder="Search by name, email, or phone" required>
    <button type="submit" name="submit">Search</button>
</form>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Actions</th>
    </tr>

<?php
if(!empty($results)){
    foreach($results as $row){ ?>
        <tr>
            <td><a href="data.php?data=<?= $row['id'] ?>"><?= htmlspecialchars($row['id']) ?></a></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id'] ?>" class="edit">Edit</a>
                <a href="delete.php?id=<?= $row['id'] ?>" class="delete" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
<?php
    }
} elseif(isset($_POST['submit'])){
    echo "<tr><td colspan='5' class='no-results'>No results found</td></tr>";
}
?>
</table>

</body>
</html>
