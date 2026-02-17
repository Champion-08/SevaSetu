<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
<title>About | SevaSetu</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    margin:0;
    padding:0;
    font-family:'Segoe UI',sans-serif;
}

.navbar{
    background:black;
    padding:15px 40px;
}

.navbar-brand{
    color:#2ecc71 !important;
    font-size:32px;
    font-weight:bold;
}

.nav-link{
    color:white !important;
    margin-right:25px;
}

.btn-green{
    background:#2ecc71;
    color:black;
    font-weight:600;
    border-radius:10px;
    padding:8px 20px;
}

.hero{
    height:100vh;
    background:url('images/hero.jpg') center center/cover no-repeat;
    position:relative;
}

.overlay{
    background:rgba(0,50,0,0.75);
    height:100%;
    width:100%;
    display:flex;
    justify-content:center;
    align-items:center;
}

.about-box{
    background:rgba(0,0,0,0.8);
    padding:60px;
    border-radius:15px;
    max-width:800px;
    color:white;
    text-align:center;
}
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="index.php">SevaSetu</a>

    <div class="ms-auto">
        <a href="index.php" class="nav-link d-inline">Home</a>
        <a href="about.php" class="nav-link d-inline">About Us</a>
        <a href="projects.php" class="nav-link d-inline">Projects</a>
        <a href="contact.php" class="nav-link d-inline">Contact</a>
        <a href="feedback.php" class="nav-link d-inline">Feedback</a>
        <a href="login.php" class="btn btn-green ms-3">Login</a>
        <a href="register.php" class="btn btn-green ms-2">Register</a>
    </div>
</nav>

<section class="hero">
    <div class="overlay">

        <div class="about-box">

            <h1 class="text-success mb-4">About SevaSetu</h1>

            <p class="lead">
                Bridging Kindness & Need by connecting donors, volunteers, and NGOs.
            </p>

            <hr>

            <p>
                Our mission is to create a transparent and powerful platform
                that makes helping others simple and impactful.
            </p>

            <p>
                Together we build a stronger, kinder society.
            </p>

        </div>

    </div>
</section>

</body>
</html>
