<?php
session_start();
include "db.php";

/* 🔒 Protect Page */
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

/* Get Full User Info */
$user_query = mysqli_query($conn, "SELECT name, email, phone, profile_photo FROM users WHERE id='$user_id'");
$user_data = mysqli_fetch_assoc($user_query);

$name = $user_data['name'] ?? '';
$email = $user_data['email'] ?? '';
$phone = $user_data['phone'] ?? '';
$profile_photo = $user_data['profile_photo'] ?? '';

/* Get Total Donations */
$total_query = "SELECT SUM(amount) AS total FROM donations WHERE user_id = '$user_id'";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_amount = $total_row['total'] ? $total_row['total'] : 0;

/* Get Donation History */
$history_query = "SELECT * FROM donations 
                  WHERE user_id = '$user_id' 
                  ORDER BY donation_date DESC";
$history_result = mysqli_query($conn, $history_query);
?>

<!DOCTYPE html>
<html>
<head>
<title>User Dashboard | SevaSetu</title>

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

.add-btn{
background:#22c55e;
padding:10px 18px;
border-radius:8px;
color:black;
text-decoration:none;
font-weight:bold;
margin-right:10px;
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

table{
width:100%;
border-collapse:collapse;
margin-top:20px;
}

table th, table td{
padding:12px;
border-bottom:1px solid rgba(255,255,255,0.2);
text-align:left;
}
</style>
</head>

<body>

<div class="topbar">
<div class="logo">SevaSetu</div>
<a href="logout.php" class="logout">Logout</a>
</div>

<div class="container">

<!-- Profile Card -->
<div class="card">

<?php if($profile_photo != ""){ ?>
<img src="uploads/<?php echo $profile_photo; ?>" class="profile-img">
<?php } ?>

<h2><?php echo htmlspecialchars($name); ?></h2>

<div class="profile-details">
<p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
<p><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
<p><strong>Total Donated:</strong> ₹ <?php echo number_format($total_amount,2); ?></p>
</div>

<br>

<a href="user_add_donation.php" class="add-btn">+ Add Donation</a>
<a href="edit_profile.php" class="add-btn">Edit Profile</a>

</div>

<!-- Donation History -->
<div class="card">
<h3>Your Donation History</h3>

<?php if(mysqli_num_rows($history_result) > 0){ ?>

<table>
<tr>
<th>Amount</th>
<th>Purpose</th>
<th>Date</th>
</tr>

<?php while($row = mysqli_fetch_assoc($history_result)){ ?>
<tr>
<td>₹ <?php echo $row['amount']; ?></td>
<td><?php echo htmlspecialchars($row['purpose']); ?></td>
<td><?php echo $row['donation_date']; ?></td>
</tr>
<?php } ?>

</table>

<?php } else { ?>
<p>No donations yet.</p>
<?php } ?>

</div>

</div>

</body>
</html>
