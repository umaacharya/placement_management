<?php include 'config.php';

$id=$_SESSION['student'];
$data=$conn->query("SELECT * FROM students WHERE id='$id'")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Profile</title>

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#e3f2fd,#f4f6f9);
}

/* CENTER WRAPPER */
.wrapper{
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
}

/* CARD */
.container{
    width:100%;
    max-width:420px;
    background:#fff;
    padding:30px;
    border-radius:16px;
    box-shadow:0 15px 35px rgba(0,0,0,0.1);
    animation:fadeIn 0.5s ease;
}

/* TITLE */
h2{
    text-align:center;
    margin-bottom:20px;
    color:#2c3e50;
}

/* INPUT */
input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border-radius:8px;
    border:1px solid #ddd;
    background:#f9f9f9;
    transition:0.3s;
    font-size:14px;
}

input:focus{
    border-color:#0072ff;
    background:#fff;
    outline:none;
    box-shadow:0 0 5px rgba(0,114,255,0.2);
}

/* BUTTON */
button{
    width:100%;
    padding:12px;
    margin-top:10px;
    border:none;
    border-radius:8px;
    background:linear-gradient(45deg,#0072ff,#00c6ff);
    color:#fff;
    font-weight:600;
    font-size:15px;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    transform:translateY(-2px);
    box-shadow:0 8px 20px rgba(0,114,255,0.3);
}

/* ANIMATION */
@keyframes fadeIn{
    from{opacity:0; transform:translateY(20px);}
    to{opacity:1; transform:translateY(0);}
}

/* RESPONSIVE */
@media(max-width:480px){
    .container{
        margin:15px;
        padding:20px;
    }
}
</style>

</head>

<body>

<div class="wrapper">

<div class="container">
<h2>Edit Profile</h2>

<form method="POST">
<input name="name" value="<?= $data['name'] ?>" placeholder="Full Name">
<input name="email" value="<?= $data['email'] ?>" placeholder="Email">
<input name="cgpa" value="<?= $data['cgpa'] ?>" placeholder="CGPA">
<input name="skills" value="<?= $data['skills'] ?>" placeholder="Skills">
<button name="up">Update Profile</button>
</form>

</div>

</div>

</body>
</html>

<?php
if(isset($_POST['up'])){
$conn->query("UPDATE students SET 
name='$_POST[name]',
email='$_POST[email]',
cgpa='$_POST[cgpa]',
skills='$_POST[skills]'
WHERE id='$id'");

header("Location: student_dashboard.php");
}
?>