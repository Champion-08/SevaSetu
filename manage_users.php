<?php
session_start();
include "db.php";

/* 🔒 Admin Only */
if (!isset($_SESSION['id']) || $_SESSION['role'] !== "admin") {
    header("Location: login.php");
    exit();
}

/* 🔥 Delete User */
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);

    // Prevent admin from deleting himself
    if ($delete_id != $_SESSION['id']) {
        mysqli_query($conn, "DELETE FROM users WHERE id = $delete_id");
    }

    header("Location: manage_users.php");
    exit();
}

/* 📥 Fetch All Users */
$result = mysqli_query($conn, "
    SELECT id, name, email, role, created_at 
    FROM users 
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Users | SevaSetu Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
body{
margin:0;
font-family:Segoe UI;
background:linear-gradient(135deg,#0f172a,#0f5e3d);
color:white;
}

/* TOPBAR */
.topbar{
display:flex;
justify-content:space-between;
align-items:center;
padding:18px 40px;
background:rgba(255,255,255,0.08);
backdrop-filter:blur(10px);
}

.logo{
color:#22c55e;
font-size:24px;
font-weight:bold;
}

.back-btn{
background:#22c55e;
padding:10px 18px;
border-radius:10px;
text-decoration:none;
color:black;
font-weight:bold;
transition:0.3s;
}

.back-btn:hover{
background:#16a34a;
}

/* CONTAINER */
.container{
padding:40px;
}

/* CARD */
.card{
background:rgba(255,255,255,0.08);
padding:30px;
border-radius:20px;
box-shadow:0 10px 30px rgba(0,0,0,0.6);
backdrop-filter:blur(12px);
}

/* TABLE */
table{
width:100%;
border-collapse:collapse;
margin-top:20px;
}

th, td{
padding:12px;
text-align:center;
}

th{
background:rgba(255,255,255,0.15);
color:#bbf7d0;
}

tr{
background:rgba(255,255,255,0.05);
transition:0.3s;
}

tr:hover{
background:rgba(255,255,255,0.15);
}

/* BUTTONS */
.delete-btn{
padding:6px 12px;
border-radius:6px;
text-decoration:none;
font-weight:bold;
background:#ef4444;
color:white;
}

.delete-btn:hover{
background:#dc2626;
}
</style>
</head>

<body>

<!-- 🔝 Topbar -->
<div class="topbar">
<div class="logo">SevaSetu Admin</div>
<a href="admin_dashboard.php" class="back-btn">⬅ Dashboard</a>
</div>

<div class="container">

<div class="card">
<h2>All Registered Users</h2>

<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Role</th>
<th>Joined</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo htmlspecialchars($row['name']); ?></td>
<td><?php echo htmlspecialchars($row['email']); ?></td>
<td><?php echo ucfirst($row['role']); ?></td>
<td><?php echo $row['created_at']; ?></td>
<td>

<?php if($row['id'] != $_SESSION['id']) { ?>
<a href="manage_users.php?delete=<?php echo $row['id']; ?>"
   class="delete-btn"
   onclick="return confirm('Are you sure you want to delete this user?')">
Delete
</a>
<?php } else { ?>
Admin
<?php } ?>

</td>
</tr>
<?php } ?>

</table>

</div>

</div>

</body>
</html>
