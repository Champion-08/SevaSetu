<?php
session_start();
include("db.php");

$message = "";

if(!isset($_GET['token'])){
    die("Invalid Access!");
}

$token = mysqli_real_escape_string($conn, $_GET['token']);

// Check token only (without expiry first)
$result = mysqli_query($conn, "SELECT * FROM users WHERE reset_token='$token'");
$user = mysqli_fetch_assoc($result);

if(!$user){
    die("<h3 style='color:red;text-align:center;margin-top:100px;'>Invalid Token</h3>");
}

// Check expiry manually
if(strtotime($user['token_expiry']) < time()){
    die("<h3 style='color:red;text-align:center;margin-top:100px;'>Token Expired</h3>");
}

if(isset($_POST['reset_password'])){

    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm  = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if($password === $confirm){

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        mysqli_query($conn, "UPDATE users 
                             SET password='$hashed',
                                 reset_token=NULL,
                                 token_expiry=NULL
                             WHERE id='{$user['id']}'");

        $message = "<div class='success'>
                        Password reset successful. 
                        <a href='login.php'>Login Now</a>
                    </div>";

    }else{
        $message = "<div class='error'>Passwords do not match!</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password - SevaSetu</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body{
            background:#f0fdf4;
            font-family:Arial;
        }

        .box{
            width:400px;
            margin:100px auto;
            background:white;
            padding:30px;
            border-radius:10px;
            box-shadow:0 5px 15px rgba(0,0,0,0.1);
        }

        h2{
            text-align:center;
            color:#16a34a;
            margin-bottom:20px;
        }

        input{
            width:100%;
            padding:10px;
            border:1px solid #ccc;
            border-radius:5px;
            margin-bottom:15px;
        }

        button{
            width:100%;
            padding:10px;
            background:#16a34a;
            border:none;
            color:white;
            border-radius:5px;
            cursor:pointer;
        }

        button:hover{
            background:#15803d;
        }

        .success{
            background:#dcfce7;
            color:#166534;
            padding:10px;
            border-radius:5px;
            margin-bottom:15px;
            text-align:center;
        }

        .error{
            background:#fee2e2;
            color:#991b1b;
            padding:10px;
            border-radius:5px;
            margin-bottom:15px;
            text-align:center;
        }

        .validation-error{
            color:red;
            font-size:14px;
            margin-bottom:10px;
        }
    </style>
</head>

<body>

<div class="box">
    <h2>Reset Password</h2>

    <?php echo $message; ?>

    <form id="resetForm" method="POST">

        <input type="text" name="password" id="password" placeholder="New Password">

        <input type="text" name="confirm_password" id="confirm_password" placeholder="Confirm Password">

        <div class="validation-error" id="errorMsg"></div>

        <button type="submit" name="reset_password">Reset Password</button>

    </form>
</div>

<script>
$(document).ready(function(){

    $("#resetForm").submit(function(e){

        var pass = $("#password").val().trim();
        var confirm = $("#confirm_password").val().trim();

        if(pass == "" || confirm == ""){
            $("#errorMsg").text("All fields are required.");
            e.preventDefault();
        }
        else if(pass.length < 6){
            $("#errorMsg").text("Password must be at least 6 characters.");
            e.preventDefault();
        }
        else if(pass !== confirm){
            $("#errorMsg").text("Passwords do not match.");
            e.preventDefault();
        }
        else{
            $("#errorMsg").text("");
        }

    });

});
</script>

</body>
</html>
