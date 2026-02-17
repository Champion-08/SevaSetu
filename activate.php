<?php
require_once __DIR__ . "/db.php";

$message = "";

if(isset($_GET['code'])){

    $code = $_GET['code'];

    // Find user with this activation code
    $stmt = $conn->prepare("SELECT id, status FROM users WHERE activation_code=?");
    $stmt->bind_param("s",$code);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1){

        $user = $result->fetch_assoc();

        if($user['status'] == 1){
            $message = "Your account is already activated.";
        } 
        else{

            // Activate account
            $update = $conn->prepare("UPDATE users SET status=1, activation_code=NULL WHERE id=?");
            $update->bind_param("i",$user['id']);

            if($update->execute()){
                $message = "Account activated successfully! You can now login.";
            } 
            else{
                $message = "Activation failed. Try again.";
            }
        }

    } 
    else{
        $message = "Invalid activation link.";
    }

} 
else{
    $message = "No activation code provided.";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Account Activation | SevaSetu</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
body{
margin:0;
font-family:Segoe UI;
background:linear-gradient(135deg,#0f172a,#064e3b);
display:flex;
justify-content:center;
align-items:center;
height:100vh;
color:white;
text-align:center;
}

.box{
background:rgba(255,255,255,0.08);
padding:40px;
border-radius:15px;
backdrop-filter:blur(10px);
box-shadow:0 20px 40px rgba(0,0,0,0.4);
width:350px;
}

a{
display:inline-block;
margin-top:20px;
padding:10px 20px;
background:#22c55e;
color:white;
text-decoration:none;
border-radius:8px;
font-weight:bold;
}

a:hover{
background:#16a34a;
}
</style>

</head>

<body>

<div class="box">

<h2>Account Activation</h2>

<p><?php echo $message; ?></p>

<a href="login.php">Go to Login</a>

</div>

</body>
</html>
