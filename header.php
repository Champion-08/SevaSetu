<?php
include "db.php";

if(isset($_POST['submit'])){

$email = $_POST['email'];

$token = bin2hex(random_bytes(50));
$expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

$stmt = $conn->prepare("UPDATE users SET reset_token=?, token_expiry=? WHERE email=?");
$stmt->bind_param("sss",$token,$expiry,$email);
$stmt->execute();

$reset_link = "http://localhost/SevaSetu/reset_password.php?token=$token";

echo "Reset link (for testing): <a href='$reset_link'>$reset_link</a>";

}
?>

<form method="POST">
<input type="email" name="email" placeholder="Enter Email" required>
<button name="submit">Send Reset Link</button>
</form>
