<?php include 'config.php'; ?>

<link rel="stylesheet" href="Comstyle.css">

<div class="container">
<h2>Company Register</h2>

<form method="POST">
    <input name="name" placeholder="Company Name" required>
    <input name="email" type="email" placeholder="Email" required>
    <input name="password" type="password" placeholder="Password" required>
    <button name="reg">Register</button>
</form>

<a href="company_login.php">Already have account? Login</a>
</div>

<?php
if(isset($_POST['reg'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // password hash
    $pass = password_hash($password, PASSWORD_DEFAULT);

    // check email exists
    $check = $conn->query("SELECT * FROM companies WHERE email='$email'");

    if($check->num_rows > 0){
        echo "<div class='error'>Email already registered</div>";
    } else {

        $sql = "INSERT INTO companies(name,email,password)
                VALUES('$name','$email','$pass')";

        if($conn->query($sql)){
            echo "<div class='success'>Registered Successfully</div>";
        } else {
            echo "Error: ".$conn->error;
        }
    }
}
?>