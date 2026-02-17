<?php
session_start();
include("db.php");

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message = "";

if(isset($_POST['send_link'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($check) > 0){

        $token = bin2hex(random_bytes(50));
        $expiry = date("Y-m-d H:i:s", strtotime("+15 minutes"));

        mysqli_query($conn, "UPDATE users 
                             SET reset_token='$token', token_expiry='$expiry' 
                             WHERE email='$email'");

        $mail = new PHPMailer(true);

        try{

            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'mkotecha581@rku.ac.in';   // CHANGE
            $mail->Password   = 'ystbsgkielfkqbyp'; // CHANGE
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('mkotecha581@rku.ac.in', 'SevaSetu');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset - SevaSetu';

            $mail->Body = "
                <div style='font-family:Arial;padding:20px'>
                    <h2 style='color:#16a34a;'>Password Reset Request</h2>
                    <p>Click the button below to reset your password:</p>
                    <a href='http://localhost/SevaSetu/reset_password.php?token=$token'
                       style='background:#16a34a;color:white;padding:10px 20px;
                              text-decoration:none;border-radius:5px;'>
                       Reset Password
                    </a>
                    <p style='margin-top:15px;'>This link expires in 15 minutes.</p>
                </div>
            ";

            $mail->send();

            $message = "<div class='success'>Reset link sent to your email.</div>";

        }catch(Exception $e){
            $message = "<div class='error'>Mailer Error: {$mail->ErrorInfo}</div>";
        }

    }else{
        $message = "<div class='error'>Email not found!</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password - SevaSetu</title>

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
        }

        .error{
            background:#fee2e2;
            color:#991b1b;
            padding:10px;
            border-radius:5px;
            margin-bottom:15px;
        }

        .back{
            text-align:center;
            margin-top:15px;
        }

        .back a{
            text-decoration:none;
            color:#16a34a;
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
    <h2>Forgot Password</h2>

    <?php echo $message; ?>

    <form id="forgotForm" method="POST">

        <input type="text" name="email" id="email" placeholder="Enter your email">

        <div class="validation-error" id="emailError"></div>

        <button type="submit" name="send_link">Send Reset Link</button>

        <div class="back">
            <a href="login.php">Back to Login</a>
        </div>

    </form>
</div>

<script>
$(document).ready(function(){

    $("#forgotForm").submit(function(e){

        var email = $("#email").val().trim();
        var pattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

        if(email == ""){
            $("#emailError").text("Email is required.");
            e.preventDefault();
        }
        else if(!pattern.test(email)){
            $("#emailError").text("Enter valid email.");
            e.preventDefault();
        }
        else{
            $("#emailError").text("");
        }

    });

});
</script>

</body>
</html>
