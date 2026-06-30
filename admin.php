<?php include 'config.php'; ?>

<link rel="stylesheet" href="Amstyle.css">

<div class="container">
<h2>Admin Login</h2>

<form method="POST">
    <input name="username" placeholder="Username" required>
    <input name="password" type="password" placeholder="Password" required>
    <button name="login">Login</button>
</form>

<a href="admin_register.php">New Admin? Register</a>
</div>

<?php
if(isset($_POST['login'])){

    $user = $_POST['username'];
    $pass = $_POST['password'];

    $res = $conn->query("SELECT * FROM admin WHERE username='$user'");

    if($res->num_rows > 0){

        $admin = $res->fetch_assoc();

        if(password_verify($pass, $admin['password'])){
            $_SESSION['admin'] = $admin['id'];

            header("Location: admin_dashboard.php");
            exit();
        } else {
            echo "<div class='error'>Wrong Password</div>";
        }

    } else {
        echo "<div class='error'>Please Register First</div>";
    }
}
?>