<?php
session_start();
include "db.php";

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['save'])){

$phone = $_POST['phone'];
$address = $_POST['address'];
$user_id = $_SESSION['id'];

$sql = "UPDATE users SET phone=?, address=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi",$phone,$address,$user_id);
$stmt->execute();

header("Location: profile.php");
exit();
}
?>

<?php include "header.php"; ?>

<div class="container">
<h2>Create Profile</h2>

<form method="POST">

<input type="text" name="phone" placeholder="Phone Number" required><br><br>
<textarea name="address" placeholder="Address" required></textarea><br><br>

<button type="submit" name="save">Save Profile</button>

</form>
</div>

<?php include "footer.php"; ?>
