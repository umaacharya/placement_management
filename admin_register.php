<?php include 'config.php'; ?>

<link rel="stylesheet" href="Amstyle.css">

<div class="container">
<h2>Admin Register</h2>

<form method="POST">
    <input name="username" placeholder="Username" required>
    <input name="password" type="password" placeholder="Password" required>
    <button name="reg">Register</button>
</form>

<a href="admin.php">Already have account? Login</a>
</div>

<?php
if(isset($_POST['reg'])){

    $user = $_POST['username'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // check existing
    $check = $conn->query("SELECT * FROM admin WHERE username='$user'");

    if($check->num_rows > 0){
        echo "<div class='error'>Username already exists</div>";
    } else {

        $conn->query("INSERT INTO admin(username,password)
        VALUES('$user','$pass')");

        echo "<div class='success'>Admin Registered</div>";
    }
}
?>