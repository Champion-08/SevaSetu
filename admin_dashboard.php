<?php
session_start();
include "db.php";

/* 🔒 Check Login */
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

/* 🔒 Allow Only Admin */
if ($_SESSION['role'] !== "admin") {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['id'];
$admin_name = $_SESSION['name'];

/* 📊 Fetch Admin Statistics */

// Total Users
// Total Users
$stmt = $conn->prepare("SELECT COUNT(*) as total_users FROM users");
$stmt->execute();
$user_result = $stmt->get_result();
$total_users = $user_result->fetch_assoc()['total_users'] ?? 0;
$stmt->close();


// Total Donations
$stmt = $conn->prepare("SELECT COUNT(*) as total_donations FROM donations");
$stmt->execute();
$donation_result = $stmt->get_result();
$total_donations = $donation_result->fetch_assoc()['total_donations'] ?? 0;
$stmt->close();

// Total Donation Amount
$stmt = $conn->prepare("SELECT SUM(amount) as total_amount FROM donations");
$stmt->execute();
$amount_result = $stmt->get_result();
$total_amount = $amount_result->fetch_assoc()['total_amount'] ?? 0;
$stmt->close();

// ✅ Total Contact Messages
$stmt = $conn->prepare("SELECT COUNT(*) as total_contacts FROM contact_messages");
$stmt->execute();
$contact_result = $stmt->get_result();
$total_contacts = $contact_result->fetch_assoc()['total_contacts'] ?? 0;
$stmt->close();

// ✅ Total Feedback
$stmt = $conn->prepare("SELECT COUNT(*) as total_feedback FROM feedback");
$stmt->execute();
$feedback_result = $stmt->get_result();
$total_feedback = $feedback_result->fetch_assoc()['total_feedback'] ?? 0;
$stmt->close();

?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard | SevaSetu</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

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

.logout{
background:#ef4444;
padding:10px 18px;
border-radius:10px;
text-decoration:none;
color:white;
font-weight:bold;
transition:0.3s;
}

.logout:hover{
background:#dc2626;
}

.container{
padding:40px;
}

.card{
background:rgba(255,255,255,0.08);
padding:25px;
border-radius:15px;
margin-bottom:20px;
box-shadow:0 10px 25px rgba(0,0,0,0.5);
}

.button{
display:inline-block;
margin-top:15px;
margin-right:10px;
background:#22c55e;
padding:10px 18px;
border-radius:8px;
color:black;
text-decoration:none;
font-weight:bold;
transition:0.3s;
}

.button:hover{
background:#16a34a;
}

.stats{
display:flex;
gap:20px;
flex-wrap:wrap;
margin-top:20px;
}

.stat-box{
flex:1;
min-width:220px;
background:rgba(255,255,255,0.08);
padding:25px;
border-radius:15px;
text-align:center;
box-shadow:0 10px 25px rgba(0,0,0,0.4);
transition:0.3s;
}

.stat-box:hover{
transform:translateY(-5px);
background:rgba(255,255,255,0.15);
}

.stat-box h3{
margin-bottom:10px;
font-size:18px;
color:#bbf7d0;
}

.stat-box h2{
font-size:28px;
margin:0;
}
</style>
</head>

<body>

<div class="topbar">
<div class="logo">SevaSetu Admin</div>
<a href="logout.php" class="logout">Logout</a>
</div>

<div class="container">

<!-- Welcome Card -->
<div class="card">
<h2>
Welcome Admin, <?php echo htmlspecialchars($admin_name); ?> 👋
</h2>
<p>Manage users, donations, contacts and feedback.</p>

<!-- ADMIN ACTION BUTTONS -->
<a href="manage_donations.php" class="button">Manage Donations</a>
<a href="manage_users.php" class="button">Manage Users</a>
<a href="admin_contact.php" class="button">View Contact Messages</a>
<a href="admin_feedback.php" class="button">View Feedback</a>
</div>

<!-- Statistics Section -->
<div class="stats">

<div class="stat-box">
<h3>Total Users</h3>
<h2><?php echo $total_users; ?></h2>
</div>

<div class="stat-box">
<h3>Total Donations</h3>
<h2><?php echo $total_donations; ?></h2>
</div>

<div class="stat-box">
<h3>Total Amount Collected</h3>
<h2>₹ <?php echo number_format($total_amount ?? 0, 2); ?></h2>
</div>

<div class="stat-box">
<h3>Total Contact Messages</h3>
<h2><?php echo $total_contacts; ?></h2>
</div>

<div class="stat-box">
<h3>Total Feedback</h3>
<h2><?php echo $total_feedback; ?></h2>
</div>

</div>

</div>

</body>
</html>
