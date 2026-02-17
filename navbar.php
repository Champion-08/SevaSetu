<?php
// Get current page name for active link highlight
$current_page = basename($_SERVER['PHP_SELF']);
?>

<style>
.navbar {
    background: #000;
    padding: 15px 60px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    z-index: 1000;
}

.logo {
    font-size: 28px;
    font-weight: bold;
    color: #22c55e;
}

.nav-links {
    display: flex;
    align-items: center;
}

.nav-links a {
    color: white;
    margin: 0 15px;
    text-decoration: none;
    font-size: 16px;
    position: relative;
    transition: 0.3s ease;
}

.nav-links a:hover {
    color: #22c55e;
}

.nav-links a.active {
    color: #22c55e;
    font-weight: 600;
}

.nav-buttons a {
    padding: 8px 18px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    margin-left: 10px;
    transition: 0.3s ease;
}

.login-btn {
    background: #22c55e;
    color: black;
}

.register-btn {
    background: #16a34a;
    color: white;
}

.nav-buttons a:hover {
    opacity: 0.8;
}

/* Responsive */
@media (max-width: 900px) {
    .navbar {
        flex-direction: column;
        padding: 15px 20px;
    }

    .nav-links {
        margin: 15px 0;
        flex-wrap: wrap;
        justify-content: center;
    }

    .nav-links a {
        margin: 8px 10px;
    }
}
</style>

<div class="navbar">

    <div class="logo">
        <a href="index.php" style="color:#22c55e; text-decoration:none;">
            SevaSetu
        </a>
    </div>

    <div class="nav-links">
        <a href="index.php" class="<?php if($current_page=='index.php') echo 'active'; ?>">Home</a>
        <a href="about.php" class="<?php if($current_page=='about.php') echo 'active'; ?>">About Us</a>
        <a href="projects.php" class="<?php if($current_page=='projects.php') echo 'active'; ?>">Projects</a>
        <a href="contact.php" class="<?php if($current_page=='contact.php') echo 'active'; ?>">Contact</a>
        <a href="feedback.php" class="<?php if($current_page=='feedback.php') echo 'active'; ?>">Feedback</a>
        <a href="privacy.php" class="<?php if($current_page=='privacy.php') echo 'active'; ?>">Privacy</a>
    </div>

    <div class="nav-buttons">
        <a href="login.php" class="login-btn">Login</a>
        <a href="register.php" class="register-btn">Register</a>
    </div>

</div>
