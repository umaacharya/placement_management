<?php include 'config.php'; ?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Login</title>

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background: linear-gradient(135deg,#eef2f3,#dfe9f3);
}

/* Wrapper */
.main{
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
    padding:20px;
}

/* Card */
.container{
    width:100%;
    max-width:400px;
    background:#fff;
    padding:30px;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

/* Title */
h2{
    text-align:center;
    margin-bottom:20px;
    color:#2c3e50;
}

/* Inputs */
input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border-radius:8px;
    border:1px solid #ccc;
    background:#f9f9f9;
    outline:none;
    transition:0.3s;
}

input:focus{
    border-color:#0072ff;
    background:#fff;
}

/* Button */
button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:8px;
    background:linear-gradient(45deg,#0072ff,#00c6ff);
    color:#fff;
    font-weight:bold;
    cursor:pointer;
}

button:hover{
    opacity:0.9;
}

/* Messages */
.error{
    color:#dc3545;
    text-align:center;
    margin-top:10px;
}

.success{
    color:#28a745;
    text-align:center;
}

/* Link */
.link{
    text-align:center;
    margin-top:15px;
}

.link a{
    color:#0072ff;
    text-decoration:none;
}

/* Mobile */
@media (max-width:500px){
    .container{
        padding:20px;
    }
}
</style>

</head>
<body>

<div class="main">

<div class="container">
<h2>🔐 Student Login</h2>

<form method="POST">
<input name="email" type="email" placeholder="Enter Email" required>
<input name="pass" type="password" placeholder="Enter Password" required>
<button name="login">Login</button>
</form>

<div class="link">
    Don't have account? <a href="student_register.php">Register</a>
</div>

</div>

</div>

</body>
</html>

<?php
if(isset($_POST['login'])){
$res=$conn->query("SELECT * FROM students WHERE email='$_POST[email]'");

if($res->num_rows>0){
$data=$res->fetch_assoc();

if(password_verify($_POST['pass'],$data['password'])){
$_SESSION['student']=$data['id'];
header("Location: student_dashboard.php");
}else{
echo "<div class='error'>❌ Wrong Password</div>";
}
}else{
echo "<div class='error'>⚠️ Register First</div>";
}
}
?>