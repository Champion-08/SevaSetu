<?php
session_start();
include "db.php";

/* 🔒 Protect Page */
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

$message = "";
$user_id = $_SESSION['id'];

if (isset($_POST['donate'])) {
    $amount = floatval($_POST['amount']);
    $purpose = trim($_POST['purpose']);

    if ($amount > 0 && !empty($purpose)) {
        // ✅ SECURE PREPARED STATEMENT - NO SQL INJECTION
        $stmt = $conn->prepare("INSERT INTO donations (user_id, amount, purpose) VALUES (?, ?, ?)");
        $stmt->bind_param("ids", $user_id, $amount, $purpose);  // i=int, d=double, s=string
        
        if ($stmt->execute()) {
            $stmt->close();
            header("Location: user_dashboard.php");
            exit();
        } else {
            $message = "Donation failed! Please try again.";
        }
        $stmt->close();
    } else {
        $message = "Please enter valid amount (>0) and purpose!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Donation | SevaSetu</title>

<style>
body{
margin:0;
font-family:Segoe UI;
background:linear-gradient(135deg,#0f172a,#0f5e3d);
color:white;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
}

.form-box{
background:rgba(255,255,255,0.08);
padding:30px;
border-radius:15px;
width:350px;
backdrop-filter:blur(10px);
}

input, textarea{
width:100%;
padding:10px;
margin:10px 0;
border-radius:8px;
border:none;
box-sizing:border-box;
}

button{
background:#22c55e;
padding:12px;
border:none;
border-radius:8px;
width:100%;
font-weight:bold;
cursor:pointer;
font-size:16px;
}

button:hover{
background:#16a34a;
}

.back{
display:block;
margin-top:15px;
text-align:center;
color:#22c55e;
text-decoration:none;
font-weight:500;
}

.error{
background:#ef4444;
color:white;
padding:10px;
border-radius:8px;
margin-bottom:15px;
text-align:center;
}
</style>
</head>

<body>

<div class="form-box">
<h2 style="color:#22c55e;margin-bottom:20px;">Add Donation</h2>

<?php if($message != ""): ?>
<div class="error"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<form method="POST">
    <input type="number" name="amount" step="0.01" min="1" 
           placeholder="Enter Amount (₹)" required>
    <textarea name="purpose" placeholder="Purpose (e.g. Tree Plantation)" 
              required rows="4"></textarea>
    <button type="submit" name="donate">Donate Now</button>
</form>

<a href="user_dashboard.php" class="back">← Back to Dashboard</a>
</div>

</body>
</html>
