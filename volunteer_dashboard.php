<?php
session_start();
include "db.php";

/* 🔐 Check Login */
if (!isset($_SESSION['id']) || $_SESSION['role'] !== "volunteer") {
    header("Location: login.php");
    exit();
}

$volunteer_id = $_SESSION['id'];

/* Get Full Volunteer Info */
$user_query = mysqli_query($conn, "SELECT name, email, phone, profile_photo, role FROM users WHERE id='$volunteer_id'");
$user_data = mysqli_fetch_assoc($user_query);

$name = $user_data['name'] ?? '';
$email = $user_data['email'] ?? '';
$phone = $user_data['phone'] ?? '';
$profile_photo = $user_data['profile_photo'] ?? '';
$role = $user_data['role'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
<title>Volunteer Dashboard | SevaSetu</title>

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

.card{
background:rgba(255,255,255,0.08);
padding:25px;
border-radius:15px;
margin-bottom:20px;
}

.profile-img{
width:100px;
height:100px;
border-radius:50%;
object-fit:cover;
border:3px solid #22c55e;
margin-bottom:15px;
}

.profile-details p{
margin:6px 0;
font-size:15px;
}

.edit-btn{
background:#22c55e;
padding:10px 18px;
border-radius:8px;
color:black;
text-decoration:none;
font-weight:bold;
display:inline-block;
margin-top:10px;
}
</style>
</head>

<body>

<div class="topbar">
<div class="logo">SevaSetu Volunteer</div>
<a href="logout.php" class="logout">Logout</a>
</div>

<div class="container">

<!-- Profile Card -->
<div class="card">

<?php if($profile_photo != ""){ ?>
<img src="uploads/<?php echo $profile_photo; ?>" class="profile-img">
<?php } ?>

<h2><?php echo htmlspecialchars($name); ?> 👋</h2>

<div class="profile-details">
<p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
<p><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
<p><strong>Role:</strong> <?php echo htmlspecialchars($role); ?></p>
</div>

<br>

<a href="edit_profile.php" class="edit-btn">Edit Profile</a>

</div>

<!-- Volunteer Info Card -->
<div class="card">
<h3>Your Contribution</h3>
<p>You help deliver donations and support SevaSetu initiatives in the community.</p>
</div>

</div>

</body>
</html>
    