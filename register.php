<?php
session_start();
require_once __DIR__ . "/db.php";

$message = "";
$activation_link = "";

if(isset($_POST['register'])){

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    if($name == "" || $email == "" || $password == "" || $role == ""){
        $message = "All fields are required.";
    } 
    else{

        // Check if email already exists
        $check = $conn->prepare("SELECT id FROM users WHERE email=?");
        $check->bind_param("s",$email);
        $check->execute();
        $check->store_result();

        if($check->num_rows > 0){
            $message = "Email already registered!";
        } 
        else{

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // 🔐 Generate activation code
            $activation_code = md5(rand(1000,9999).time());

            // Insert user with status = pending
            $stmt = $conn->prepare("INSERT INTO users (name,email,password,role,status,activation_code) VALUES (?,?,?,?,?,?)");

            $status = "pending";

            $stmt->bind_param("ssssss",
                $name,
                $email,
                $hashed_password,
                $role,
                $status,
                $activation_code
            );

            if($stmt->execute()){

                // Fake activation link (for demo)
                $activation_link = "http://localhost/SevaSetu/activate.php?code=".$activation_code;

                $message = "Registration successful! Activate your account using the link below.";
            } 
            else{
                $message = "Registration failed!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register | SevaSetu</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
$(document).ready(function() {
    $("form").validate({
        rules: {
            name: "required",
            email: { required: true, email: true },
            password: { required: true, minlength: 8 },
            phone: { required: true, digits: true, minlength: 10, maxlength: 10 },
            amount: { required: true, min: 1 },
            purpose: "required",
            address: "required",
            message: "required"
        },
        messages: {
            name: "Name is required",
            email: "Please enter valid email",
            password: { required: "Password required", minlength: "Minimum 8 characters" },
            phone: "Enter valid 10-digit phone",
            amount: "Amount must be greater than 0",
            purpose: "Purpose is required",
            address: "Address is required",
            message: "Message is required"
        },
        errorClass: "error",
        validClass: "valid"
    });
});
</script>

<style>
.error { color: #ef4444; font-size: 12px; margin-top: 5px; display: block; }
.valid { border-color: #22c55e !important; }
input.error, textarea.error { border-color: #ef4444 !important; }
</style>

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
}

.register-box{
background:rgba(255,255,255,0.08);
padding:40px;
border-radius:15px;
width:350px;
backdrop-filter:blur(10px);
box-shadow:0 20px 40px rgba(0,0,0,0.4);
}

h2{text-align:center;margin-bottom:20px;color:#22c55e;}

input, select{
width:100%;
padding:12px;
margin-bottom:15px;
border:none;
border-radius:8px;
}

button{
width:100%;
padding:12px;
background:#22c55e;
border:none;
border-radius:8px;
color:white;
font-weight:bold;
cursor:pointer;
}

button:hover{background:#16a34a;}

.error{color:#f87171;text-align:center;margin-bottom:10px;}

.success{color:#22c55e;text-align:center;margin-bottom:10px;word-break:break-all;}

.login-link{text-align:center;margin-top:15px;}

.login-link a{color:#22c55e;text-decoration:none;}
</style>
</head>

<body>

<div class="register-box">

<h2>Create Account</h2>

<?php if($message!=""){ ?>
<div class="error"><?php echo $message; ?></div>
<?php } ?>

<?php if($activation_link!=""){ ?>
<div class="success">
Activation Link:<br>
<a href="<?php echo $activation_link; ?>" style="color:#22c55e;">
Click here to activate
</a>
</div>
<?php } ?>

<form method="POST" id="registerForm">

<input type="text" name="name" id="name" placeholder="Full Name">
<input type="text" name="email" id="email" placeholder="Email">
<input type="text" name="password" id="password" placeholder="Password">

<select name="role" id="role">
<option value="">Select Role</option>
<option value="user">User</option>
<option value="volunteer">Volunteer</option>
<option value="ngo">NGO</option>
</select>

<button type="submit" name="register">Register</button>

</form>

<div class="login-link">
Already have account? <a href="login.php">Login</a>
</div>

</div>

<script>
$("#registerForm").submit(function(e){

let name = $("#name").val().trim();
let email = $("#email").val().trim();
let password = $("#password").val().trim();
let role = $("#role").val();

if(name == ""){
alert("Please enter your name");
e.preventDefault();
return;
}

if(email == ""){
alert("Please enter email");
e.preventDefault();
return;
}

let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
if(!emailPattern.test(email)){
alert("Enter valid email");
e.preventDefault();
return;
}

if(password == ""){
alert("Please enter password");
e.preventDefault();
return;
}

if(password.length < 6){
alert("Password must be at least 6 characters");
e.preventDefault();
return;
}

if(role == ""){
alert("Please select role");
e.preventDefault();
return;
}

});
</script>

</body>
</html>
