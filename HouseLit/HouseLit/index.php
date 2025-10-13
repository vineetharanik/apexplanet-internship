<?php
session_start();
include 'config.php';

// Redirect if user not logged in
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

// Pagination setup
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Total students
$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM students");
$stmt->execute();
$total_records = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
$total_pages = ceil($total_records / $limit);

// Fetch students
$stmt = $conn->prepare("SELECT * FROM students LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>All Students</title>
    <style>
        body { font-family: Arial; background:#f4f4f9; padding:20px; }
        table { border-collapse: collapse; width:80%; margin:auto; background:#fff; border-radius:10px; overflow:hidden; }
        th, td { padding:12px 20px; text-align:left; }
        th { background:#6c63ff; color:white; }
        tr:nth-child(even) { background:#f2f2f2; }
        a.button { padding:6px 12px; margin:2px; border-radius:5px; color:white; text-decoration:none; }
        a.edit { background:#00b894; }
        a.delete { background:#d63031; }
        .add-student { display:block; width:150px; margin:20px auto; background:#6c63ff; text-align:center; padding:10px; border-radius:5px; color:white; text-decoration:none; }
        .pagination { text-align:center; margin-top:20px; }
        .pagination a, .pagination span { margin:0 5px; padding:6px 12px; border-radius:5px; background:#6c63ff; color:white; text-decoration:none; }
        .pagination span.current { background:#00b894; }
    </style>
</head>
<body>

<h2>Student Records</h2>
<a href="create.php" class="add-student">+ Add New Student</a>
<a href="search.php" class="add-student" style="background:#00b894; margin-top:0;">🔍 Search Students</a>

<table>
    <tr>
        <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Actions</th>
    </tr>

    <?php foreach($students as $row){ ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td>
                <?php if(in_array($_SESSION['user_role'], ['admin','editor'])){ ?>
                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="edit">Edit</a>
                <?php } ?>
                <?php if($_SESSION['user_role'] === 'admin'){ ?>
                    <a href="delete.php?id=<?php echo $row['id']; ?>" class="delete" onclick="return confirm('Are you sure?')">Delete</a>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
</table>

<div class="pagination">
    <?php if($page>1){ echo "<a href='?page=".($page-1)."'>« Previous</a>"; } ?>
    <?php for($i=1;$i<=$total_pages;$i++){ 
        if($i==$page) echo "<span class='current'>$i</span>"; 
        else echo "<a href='?page=$i'>$i</a>";
    } ?>
    <?php if($page<$total_pages){ echo "<a href='?page=".($page+1)."'>Next »</a>"; } ?>
</div>

</body>
</html>
