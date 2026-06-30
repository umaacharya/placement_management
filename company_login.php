<?php include 'config.php'; ?>

<link rel="stylesheet" href="Comstyle.css">

<div class="container">
<h2>Company Login</h2>

<form method="POST">
    <input name="email" type="email" placeholder="Email" required>
    <input name="pass" type="password" placeholder="Password" required>
    <button name="login">Login</button>
</form>

<a href="company_register.php">New Company? Register</a>
</div>

<?php
if(isset($_POST['login'])){

    $email = $_POST['email'];
    $pass  = $_POST['pass'];

    $res = $conn->query("SELECT * FROM companies WHERE email='$email'");

    if($res->num_rows > 0){

        $user = $res->fetch_assoc();

        if(password_verify($pass, $user['password'])){
            $_SESSION['company'] = $user['id'];

            // ✅ redirect to dashboard
            header("Location: company_dashboard.php");
            exit();
        } else {
            echo "<div class='error'>Wrong Password</div>";
        }

    } else {
        echo "<div class='error'>Please Register First</div>";
    }
}
?>