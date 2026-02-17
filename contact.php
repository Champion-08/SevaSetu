<?php
session_start();
require 'db.php';

$success = "";
$error = "";

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if($name != "" && $email != "" && $message != ""){

        $stmt = $conn->prepare("INSERT INTO contact_messages (name,email,message) VALUES (?,?,?)");
        $stmt->bind_param("sss",$name,$email,$message);

        if($stmt->execute()){
            $success = "Message sent successfully!";
        } else {
            $error = "Something went wrong!";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Contact Us | SevaSetu</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

.nav-links a{
color:white;
margin:0 15px;
text-decoration:none;
}

.container{
height:calc(100vh - 70px);
display:flex;
justify-content:center;
align-items:center;
}

.form-box{
background:rgba(255,255,255,0.08);
padding:40px;
border-radius:15px;
width:400px;
}

.form-box h2{
text-align:center;
margin-bottom:20px;
color:#22c55e;
}

.input-group{
margin-bottom:15px;
}

.input-group input,
.input-group textarea{
width:100%;
padding:10px;
border-radius:6px;
border:none;
outline:none;
}

.btn{
width:100%;
padding:10px;
background:#22c55e;
border:none;
border-radius:8px;
font-weight:bold;
cursor:pointer;
}

.btn:hover{
background:#16a34a;
}

.success{
background:#16a34a;
padding:8px;
border-radius:6px;
text-align:center;
margin-bottom:10px;
}

.error{
background:#dc2626;
padding:8px;
border-radius:6px;
text-align:center;
margin-bottom:10px;
}
</style>
</head>

<body>

<div class="navbar">
<div class="logo">SevaSetu</div>
<div class="nav-links">
<a href="index.php">Home</a>
<a href="contact.php">Contact</a>
<a href="feedback.php">Feedback</a>
</div>
</div>

<div class="container">
<div class="form-box">

<h2>Contact Us</h2>

<?php if($success != "") echo "<div class='success'>$success</div>"; ?>
<?php if($error != "") echo "<div class='error'>$error</div>"; ?>

<form id="contactForm" method="POST">

<div class="input-group">
<input type="text" name="name" id="name" placeholder="Your Name">
</div>

<div class="input-group">
<input type="text" name="email" id="email" placeholder="Your Email">
</div>

<div class="input-group">
<textarea name="message" id="message" rows="4" placeholder="Your Message"></textarea>
</div>

<button type="submit" class="btn">Send Message</button>

</form>
</div>
</div>

<script>
$(document).ready(function(){

$("#contactForm").submit(function(e){

let name=$("#name").val().trim();
let email=$("#email").val().trim();
let message=$("#message").val().trim();

if(name==""){
alert("Name is required!");
e.preventDefault();
return;
}

if(email==""){
alert("Email is required!");
e.preventDefault();
return;
}

if(message==""){
alert("Message cannot be empty!");
e.preventDefault();
return;
}

});

});
</script>

</body>
</html>
     