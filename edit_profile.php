<?php
session_start();
include "db.php";

/* 🔒 Check Login */
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

/* 📌 Fetch Current User Data */
$result = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("User not found.");
}

$success = "";
$error = "";

/* 📌 Update Profile */
if (isset($_POST['update'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    // Check if photo uploaded
    if (!empty($_FILES['photo']['name'])) {

        $photo_name = $_FILES['photo']['name'];
        $photo_tmp = $_FILES['photo']['tmp_name'];
        $photo_size = $_FILES['photo']['size'];

        $ext = strtolower(pathinfo($photo_name, PATHINFO_EXTENSION));
        $allowed = array("jpg", "jpeg", "png");

        if (!in_array($ext, $allowed)) {
            $error = "Only JPG, JPEG, PNG files allowed!";
        } else {

            $new_name = "profile_" . $user_id . "_" . time() . "." . $ext;
            $upload_path = "uploads/" . $new_name;

            move_uploaded_file($photo_tmp, $upload_path);

            mysqli_query($conn, "UPDATE users SET 
                name='$name',
                email='$email',
                phone='$phone',
                profile_photo='$new_name'
                WHERE id='$user_id'");

            $_SESSION['name'] = $name;

            $success = "Profile updated successfully!";
        }

    } else {
        $error = "Profile photo is compulsory!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Profile | SevaSetu</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
body{
margin:0;
font-family:Segoe UI;
background:linear-gradient(135deg,#0f172a,#0f5e3d);
color:white;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
}

.card{
background:rgba(255,255,255,0.08);
padding:35px;
border-radius:15px;
width:420px;
box-shadow:0 10px 25px rgba(0,0,0,0.5);
backdrop-filter:blur(10px);
}

h2{
text-align:center;
margin-bottom:20px;
color:#22c55e;
}

input{
width:100%;
padding:12px;
margin-bottom:15px;
border:none;
border-radius:8px;
outline:none;
}

input[type="file"]{
background:white;
color:black;
padding:8px;
}

button{
width:100%;
padding:12px;
background:#22c55e;
border:none;
border-radius:8px;
font-weight:bold;
cursor:pointer;
transition:0.3s;
}

button:hover{
background:#16a34a;
}

.msg{
text-align:center;
margin-bottom:10px;
font-weight:bold;
}

.success{
color:#4ade80;
}

.error{
color:#f87171;
}

.preview{
text-align:center;
margin-bottom:15px;
}

.preview img{
width:100px;
height:100px;
border-radius:50%;
object-fit:cover;
border:3px solid #22c55e;
}
</style>

<script>
function validateForm(){
    let name = document.forms["editForm"]["name"].value;
    let email = document.forms["editForm"]["email"].value;
    let phone = document.forms["editForm"]["phone"].value;
    let photo = document.forms["editForm"]["photo"].value;

    if(name=="" || email=="" || phone==""){
        alert("All fields are required!");
        return false;
    }

    if(photo==""){
        alert("Profile photo is compulsory!");
        return false;
    }

    return true;
}
</script>

</head>
<body>

<div class="card">

<h2>Edit Profile</h2>

<?php if($success!="") echo "<div class='msg success'>$success</div>"; ?>
<?php if($error!="") echo "<div class='msg error'>$error</div>"; ?>

<div class="preview">
<?php if(!empty($user['profile_photo'] ?? '')){ ?>
<img src="uploads/<?php echo $user['profile_photo']; ?>">
<?php } ?>
</div>

<form name="editForm" method="POST" enctype="multipart/form-data" onsubmit="return validateForm();">

<input type="text" name="name" placeholder="Full Name"
value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" required>

<input type="text" name="email" placeholder="Email"
value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>

<input type="text" name="phone" placeholder="Phone"
value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" required>

<input type="file" name="photo" required>

<button type="submit" name="update">Update Profile</button>

</form>

</div>

</body>
</html>
