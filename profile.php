<?php
session_start();
include "db.php";

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit();
}

$id = $_SESSION['id'];

$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<?php include "header.php"; ?>

<div class="container">
<h2>My Profile</h2>

<p><b>Name:</b> <?php echo htmlspecialchars($user['name']); ?></p>
<p><b>Email:</b> <?php echo htmlspecialchars($user['email']); ?></p>
<p><b>Phone:</b> <?php echo htmlspecialchars($user['phone']); ?></p>
<p><b>Address:</b> <?php echo htmlspecialchars($user['address']); ?></p>

<a href="edit_profile.php">Edit Profile</a>
</div>

<?php include "footer.php"; ?>

-> project_animals.php : 
<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>Help Stray Animals</title>
<style>
body{
background:#020617;
color:white;
font-family:'Segoe UI',sans-serif;
text-align:center;
padding:100px;
}
h1{ color:#22c55e; }
</style>
</head>
<body>

<h1>Help Stray Animals 🐾</h1>
<p>We provide food, shelter, vaccination and emergency medical support for street animals.</p>

</body>
</html>