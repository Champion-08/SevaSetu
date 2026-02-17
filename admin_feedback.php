<?php
session_start();
require 'db.php';

// 🔐 Allow only admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
    header("Location: login.php");
    exit();
}

// Delete feedback
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM feedback WHERE id=$id");
}

$stmt = $conn->prepare("SELECT * FROM feedback ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();?>

<!DOCTYPE html>
<html>
<head>
<title>Admin - Feedback | SevaSetu</title>

<style>
body{
margin:0;
font-family:Segoe UI;
background:linear-gradient(135deg,#0f172a,#0f5e3d);
color:white;
}

.topbar{
display:flex;
justify-content:space-between;
padding:18px 40px;
background:rgba(255,255,255,0.08);
}

.logo{
color:#22c55e;
font-size:24px;
font-weight:bold;
}

.logout{
background:#ef4444;
padding:10px 18px;
border-radius:10px;
text-decoration:none;
color:white;
font-weight:bold;
}

.container{
padding:40px;
}

table{
width:100%;
border-collapse:collapse;
background:rgba(255,255,255,0.08);
border-radius:10px;
overflow:hidden;
}

th,td{
padding:12px;
text-align:left;
}

th{
background:#22c55e;
color:black;
}

tr:nth-child(even){
background:rgba(255,255,255,0.05);
}

.delete-btn{
background:#ef4444;
padding:6px 12px;
border-radius:6px;
color:white;
text-decoration:none;
}
</style>
</head>

<body>

<div class="topbar">
<div class="logo">Admin Panel - Feedback</div>
<a href="logout.php" class="logout">Logout</a>
</div>

<div class="container">

<h2>User Feedback</h2>

<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Rating</th>
<th>Feedback</th>
<th>Date</th>
<th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo htmlspecialchars($row['name']); ?></td>
<td><?php echo htmlspecialchars($row['email']); ?></td>
<td><?php echo $row['rating']; ?>/5</td>
<td><?php echo htmlspecialchars($row['feedback']); ?></td>
<td><?php echo $row['created_at']; ?></td>
<td>
<a class="delete-btn" href="?delete=<?php echo $row['id']; ?>" 
onclick="return confirm('Delete this feedback?')">Delete</a>
</td>
</tr>
<?php endwhile; ?>

</table>

</div>

</body>
</html>
