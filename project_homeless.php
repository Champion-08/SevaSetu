<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>Help Homeless | SevaSetu</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{
margin:0;
font-family:'Segoe UI',sans-serif;
background:linear-gradient(135deg,#0f172a,#0f5e3d);
color:white;
}

.navbar{
background:#000;
padding:15px 60px;
display:flex;
justify-content:space-between;
align-items:center;
}

.logo{
font-size:26px;
font-weight:bold;
color:#22c55e;
}

.container{
padding:60px;
max-width:1100px;
margin:auto;
}

.section{
background:rgba(255,255,255,0.08);
padding:30px;
border-radius:15px;
margin-bottom:30px;
}

.btn{
display:inline-block;
padding:12px 25px;
background:#22c55e;
color:black;
border-radius:10px;
text-decoration:none;
font-weight:bold;
margin-top:15px;
}

.btn:hover{
background:#16a34a;
}

h1,h2{
color:#22c55e;
}
</style>
</head>

<body>

<div class="navbar">
<div class="logo">SevaSetu</div>
<a href="index.php" style="color:white;text-decoration:none;">Back to Home</a>
</div>

<div class="container">

<h1>🏠 Help the Homeless</h1>

<div class="section">
<h2>About the Project</h2>
<p>This program supports homeless individuals by providing food, clothing, medical support, and shelter assistance.</p>
</div>

<div class="section">
<h2>Objectives</h2>
<ul>
<li>Distribute essential supplies</li>
<li>Organize donation drives</li>
<li>Support rehabilitation efforts</li>
<li>Improve living conditions</li>
</ul>
</div>

<div class="section">
<h2>Impact</h2>
<p>Your contribution can help someone regain dignity, safety, and hope.</p>
<a href="#" class="btn">Support This Cause</a>
</div>

</div>

</body>
</html>
