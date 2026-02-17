<?php
session_start();
include "db.php";

/* 🔒 Admin Only */
if (!isset($_SESSION['id']) || $_SESSION['role'] !== "admin") {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: manage_donations.php");
    exit();
}

$id = intval($_GET['id']);

/* 📥 Fetch Donation */
$result = mysqli_query($conn, "SELECT * FROM donations WHERE id = $id");
$donation = mysqli_fetch_assoc($result);

if (!$donation) {
    echo "Donation not found!";
    exit();
}

/* 🔄 Update Donation */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = floatval($_POST['amount']);

    mysqli_query($conn, 
        "UPDATE donations SET amount = '$amount' WHERE id = $id"
    );

    header("Location: manage_donations.php");
    exit();
}

$admin_name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Donation | SevaSetu Admin</title>
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

/* MAIN CONTAINER */
.container{
display:flex;
justify-content:center;
align-items:center;
height:80vh;
}

/* CARD */
.card{
background:rgba(255,255,255,0.08);
padding:40px;
border-radius:20px;
width:400px;
box-shadow:0 10px 30px rgba(0,0,0,0.6);
backdrop-filter:blur(12px);
}

.card h2{
margin-bottom:20px;
text-align:center;
}

label{
display:block;
margin-bottom:8px;
font-weight:bold;
}

input{
width:100%;
padding:10px;
border-radius:8px;
border:none;
margin-bottom:20px;
font-size:16px;
}

button{
width:100%;
padding:12px;
border:none;
border-radius:10px;
background:#22c55e;
font-weight:bold;
cursor:pointer;
transition:0.3s;
font-size:16px;
}

button:hover{
background:#16a34a;
}
</style>
</head>

<body>

<!-- 🔝 Topbar -->
<div class="topbar">
<div class="logo">SevaSetu Admin</div>
<a href="manage_donations.php" class="back-btn">⬅ Back</a>
</div>

<div class="container">

<div class="card">
<h2>Edit Donation</h2>

<form method="POST">
<label>Amount</label>
<input type="number" step="0.01" name="amount" 
       value="<?php echo htmlspecialchars($donation['amount']); ?>" required>

<button type="submit">Update Donation</button>
</form>

</div>

</div>

</body>
</html>
