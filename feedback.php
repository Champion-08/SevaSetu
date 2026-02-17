<?php
session_start();
require 'db.php';

$success = "";
$error = "";

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $rating = trim($_POST['rating']);
    $feedback = trim($_POST['feedback']);

    if($name != "" && $email != "" && $rating != "" && $feedback != ""){

        $stmt = $conn->prepare("INSERT INTO feedback (name,email,rating,feedback) VALUES (?,?,?,?)");
        $stmt->bind_param("ssis",$name,$email,$rating,$feedback);

        if($stmt->execute()){
            $success = "Thank you for your feedback!";
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
<title>Feedback | SevaSetu</title>
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
<a href="index.php" style="color:white;text-decoration:none;">Home</a>
</div>

<div class="container">
<div class="form-box">

<h2>Give Your Feedback</h2>

<?php if($success != "") echo "<div class='success'>$success</div>"; ?>
<?php if($error != "") echo "<div class='error'>$error</div>"; ?>

<form id="feedbackForm" method="POST">

<div class="input-group">
<input type="text" name="name" id="name" placeholder="Your Name">
</div>

<div class="input-group">
<input type="text" name="email" id="email" placeholder="Your Email">
</div>

<div class="input-group">
<input type="text" name="rating" id="rating" placeholder="Rating (1-5)">
</div>

<div class="input-group">
<textarea name="feedback" id="feedback" rows="4" placeholder="Your Feedback"></textarea>
</div>

<button type="submit" class="btn">Submit Feedback</button>

</form>
</div>
</div>

<script>
$(document).ready(function(){

$("#feedbackForm").submit(function(e){

let name=$("#name").val().trim();
let email=$("#email").val().trim();
let rating=$("#rating").val().trim();
let feedback=$("#feedback").val().trim();

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

if(rating=="" || rating<1 || rating>5){
alert("Rating must be between 1 and 5!");
e.preventDefault();
return;
}

if(feedback==""){
alert("Feedback cannot be empty!");
e.preventDefault();
return;
}

});

});
</script>

</body>
</html>
    