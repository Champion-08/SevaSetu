<?php
session_start();
require 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = isset($_POST['user_id']) ? trim($_POST['user_id']) : "";
    $password = isset($_POST['password']) ? trim($_POST['password']) : "";

    if ($email === "" || $password === "") {
        $error = "All fields are required!";
    } else {

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {

                $_SESSION['id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] === "admin") {
                    header("Location: admin_dashboard.php");
                    exit();
                } elseif ($user['role'] === "volunteer") {
                    header("Location: volunteer_dashboard.php");
                    exit();
                } else {
                    header("Location: user_dashboard.php");
                    exit();
                }

            } else {
                $error = "Wrong Password!";
            }

        } else {
            $error = "User not found!";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>SevaSetu - Login</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<style>
/* Validation styling */
label.error {
    color: #ef4444;
    font-size: 12px;
    margin-top: 5px;
    display: block;
}

input.error {
    border: 2px solid #ef4444 !important;
}

input.valid {
    border: 2px solid #22c55e !important;
}
</style>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: url('https://images.unsplash.com/photo-1532629345422-7515f3d16bb6') no-repeat center center/cover;
    height: 100vh;
    position: relative;
}
body::before {
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.75);
    top: 0;
    left: 0;
}
.navbar {
    background: #000;
    padding: 15px 60px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    z-index: 2;
}
.logo {
    font-size: 28px;
    font-weight: bold;
    color: #22c55e;
}
.nav-links a {
    color: white;
    margin: 0 15px;
    text-decoration: none;
}
.nav-buttons a {
    padding: 8px 18px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    margin-left: 10px;
}
.login-btn { background: #22c55e; color: black; }
.register-btn { background: #16a34a; color: white; }
.login-wrapper {
    position: relative;
    z-index: 2;
    height: calc(100vh - 70px);
    display: flex;
    justify-content: center;
    align-items: center;
}
.login-box {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    padding: 40px;
    border-radius: 15px;
    width: 350px;
    color: white;
}
.login-box h2 {
    text-align: center;
    margin-bottom: 25px;
}
.input-group { margin-bottom: 15px; }
.input-group input {
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: none;
    outline: none;
}
.btn {
    width: 100%;
    padding: 10px;
    background: #22c55e;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
}
.btn:hover { background: #16a34a; }
.server-error {
    background: #dc2626;
    padding: 8px;
    border-radius: 6px;
    margin-bottom: 10px;
    text-align: center;
}
.forgot {
    text-align: right;
    margin-top: 8px;
}
.forgot a {
    color: #22c55e;
    text-decoration: none;
    font-size: 14px;
}
</style>
</head>

<body>

<div class="navbar">
    <div class="logo">SevaSetu</div>
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="#">About Us</a>
        <a href="#">Projects</a>
        <a href="#">Contact</a>
        <a href="#">Feedback</a>
    </div>
    <div class="nav-buttons">
        <a href="login.php" class="login-btn">Login</a>
        <a href="register.php" class="register-btn">Register</a>
        <a href="forgot_password.php">Forgot Password?</a>
    </div>
</div>

<div class="login-wrapper">
    <div class="login-box">
        <h2>Login</h2>

        <?php if (!empty($error)) : ?>
            <div class="server-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form id="loginForm" method="POST">

            <div class="input-group">
                <input type="text" name="user_id" id="user_id" placeholder="Email">
            </div>

            <div class="input-group">
                <input type="text" name="password" id="password" placeholder="Password">
            </div>

            <button type="submit" class="btn">Login</button>

            <div class="forgot">
                <a href="forgot_password.php">Forgot Password?</a>
            </div>

        </form>
    </div>
</div>

<script>
$(document).ready(function(){

    $("#loginForm").validate({
        rules: {
            user_id: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 4
            }
        },
        messages: {
            user_id: {
                required: "Email is required",
                email: "Enter a valid email"
            },
            password: {
                required: "Password is required",
                minlength: "Minimum 4 characters"
            }
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        }
    });

});
</script>

</body>
</html>
