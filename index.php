<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>SevaSetu | Home</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
/* ===== YOUR ORIGINAL CSS — UNCHANGED ===== */
*{box-sizing:border-box;}
body{margin:0;font-family:'Segoe UI',sans-serif;background:#020617;color:white;overflow-x:hidden;}
.navbar{position:fixed;top:0;left:0;width:100%;display:flex;justify-content:space-between;align-items:center;padding:18px 60px;background:rgba(0,0,0,0.75);backdrop-filter:blur(12px);z-index:10000;}
.logo{font-size:28px;font-weight:bold;color:#22c55e;}
.nav-links{display:flex;align-items:center;gap:25px;}
.nav-links a{color:white;text-decoration:none;font-weight:500;cursor:pointer;}
.nav-links a:hover{color:#22c55e;}
.auth-btn{background:#22c55e;color:#000 !important;padding:8px 18px;border-radius:6px;font-weight:600;}
.auth-btn:hover{background:#16a34a;color:white !important;}
.dropdown{position:relative;}
.dropdown-toggle{display:flex;align-items:center;gap:6px;}
.dropdown-content{display:none;position:absolute;top:100%;left:0;background:#0f172a;min-width:220px;border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,0.6);padding:10px 0;margin-top:10px;z-index:20000;}
.dropdown-content a{display:block;padding:14px 20px;color:white;text-decoration:none;}
.dropdown-content a:hover{background:rgba(34,197,94,0.2);}
.dropdown.active .dropdown-content{display:block;}
.hero{height:100vh;position:relative;margin-top:80px;}
.slide{position:absolute;inset:0;background-size:cover;background-position:center;opacity:0;transition:opacity 1s;}
.slide.active{opacity:1;}
.overlay{position:absolute;inset:0;background:linear-gradient(rgba(2,6,23,0.7), rgba(6,78,59,0.7));}
.hero-content{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;z-index:5;}
.hero h1{font-size:60px;margin-bottom:20px;}
.hero p{font-size:22px;color:#e5e7eb;margin-bottom:30px;}
.hero button{padding:15px 35px;font-size:18px;background:#22c55e;border:none;border-radius:8px;cursor:pointer;font-weight:bold;}
.section{padding:100px 60px;text-align:center;}
.section h2{font-size:38px;color:#22c55e;}
.projects{display:flex;flex-wrap:wrap;justify-content:center;gap:30px;margin-top:50px;}
.project-card{width:300px;background:rgba(255,255,255,0.05);border-radius:16px;overflow:hidden;cursor:pointer;transition:0.4s;}
.project-card:hover{transform:translateY(-10px);}
.project-card img{width:100%;height:200px;object-fit:cover;}
.project-card h3{color:#22c55e;margin:15px 0 5px;}
.footer{background:#020617;padding:40px;text-align:center;color:#9ca3af;}
.footer a{color:#22c55e;margin:0 15px;text-decoration:none;}
.footer a:hover{text-decoration:underline;}
</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
<div class="logo">SevaSetu</div>

<div class="nav-links">
<a href="index.php">Home</a>

<!-- About Us (Direct Link Now) -->
<a href="about.php">About Us</a>

<div class="dropdown">
<a class="dropdown-toggle">Projects ▾</a>
<div class="dropdown-content">
<a href="project_tree.php">Tree Plantation</a>
<a href="project_animals.php">Help Stray Animals</a>
<a href="project_homeless.php">Help Homeless</a>
</div>
</div>

<a href="contact.php">Contact</a>
<a href="feedback.php">Feedback</a>

<?php if(isset($_SESSION['user_role'])){ ?>
<a href="logout.php" class="auth-btn">Logout</a>
<?php } else { ?>
<a href="login.php" class="auth-btn">Login</a>
<a href="register.php" class="auth-btn">Register</a>
<?php } ?>

</div>
</div>

<!-- HERO -->
<div class="hero">
<div class="slide active" style="background-image:url('https://images.unsplash.com/photo-1593113630400-ea4288922497');"></div>
<div class="slide" style="background-image:url('https://images.unsplash.com/photo-1469571486292-0ba58a3f068b');"></div>
<div class="slide" style="background-image:url('https://images.unsplash.com/photo-1532629345422-7515f3d16bb6');"></div>
<div class="overlay"></div>

<div class="hero-content">
<h1>Bridging Kindness & Need</h1>
<p>Connecting Donors, Volunteers & NGOs</p>
<button onclick="location.href='register.php'">Start Helping Today</button>
</div>
</div>

<!-- PROJECTS -->
<div class="section">
<h2>Our Projects</h2>

<div class="projects">
<div class="project-card" onclick="location.href='project_tree.php'">
<img src="https://images.unsplash.com/photo-1469474968028-56623f02e42e">
<h3>Tree Plantation</h3>
<p>Making Earth greener for future generations.</p>
</div>

<div class="project-card" onclick="location.href='project_animals.php'">
<img src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b">
<h3>Help Stray Animals</h3>
<p>Food, shelter and medical care for street animals.</p>
</div>

<div class="project-card" onclick="location.href='project_homeless.php'">
<img src="https://images.unsplash.com/photo-1517022812141-23620dba5c23">
<h3>Help Homeless</h3>
<p>Providing food, clothes and shelter support.</p>
</div>
</div>
</div>

<!-- FOOTER -->
<div class="footer">
<p>© 2026 SevaSetu</p>
<p>
<a href="privacy.php">Privacy Policy</a>
<a href="faqs.php">FAQs</a>
<a href="terms.php">Terms & Conditions</a>
</p>
</div>

<script>
// Slideshow
let slides = document.querySelectorAll(".slide");
let i = 0;
setInterval(() => {
slides[i].classList.remove("active");
i = (i + 1) % slides.length;
slides[i].classList.add("active");
}, 4000);

// Dropdown
document.querySelectorAll(".dropdown-toggle").forEach(toggle => {
toggle.addEventListener("click", e => {
e.preventDefault();
let parent = toggle.parentElement;
document.querySelectorAll(".dropdown").forEach(d => {
if(d !== parent) d.classList.remove("active");
});
parent.classList.toggle("active");
});
});

document.addEventListener("click", e => {
if(!e.target.closest(".dropdown")){
document.querySelectorAll(".dropdown").forEach(d => d.classList.remove("active"));
}
});
</script>

</body>
</html>
