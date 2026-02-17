<?php
session_start();
if(!isset($_SESSION['user'])){
header("Location: ../login.php");
exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>NGO Dashboard | SevaSetu</title>

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
</style>
</head>

<body>

<div class="topbar">
<div class="logo">SevaSetu NGO</div>
<a href="../logout.php" class="logout">Logout</a>
</div>

<div class="container">

<div class="card">
<h2>Welcome NGO Partner</h2>
<p>Manage requests and donations.</p>
</div>

</div>

</body>
</html>