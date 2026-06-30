<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Register</title>

<style>
body{
    font-family:'Segoe UI',sans-serif;
    margin:0;
    background: linear-gradient(135deg,#eef2f3,#dfe9f3);
}

/* Wrapper */
.main-wrapper{
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
    padding:20px;
}

/* Card */
.container{
    width:100%;
    max-width:420px;
    padding:25px;
    background:#fff;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

/* Title */
h2{
    text-align:center;
    margin-bottom:20px;
    color:#2c3e50;
    font-size:22px;
}

/* Input Group */
.input-group{
    margin-bottom:15px;
}

.input-group label{
    font-size:14px;
    color:#555;
}

/* Inputs */
input{
    width:100%;
    padding:12px;
    margin-top:5px;
    border-radius:8px;
    border:1px solid #ccc;
    background:#f9f9f9;
    outline:none;
}

input:focus{
    border-color:#0072ff;
    background:#fff;
}

/* Button */
button{
    width:100%;
    padding:12px;
    margin-top:10px;
    border:none;
    border-radius:8px;
    background:linear-gradient(45deg,#0072ff,#00c6ff);
    color:#fff;
    font-weight:bold;
    cursor:pointer;
}

/* Link */
.login-link{
    text-align:center;
    margin-top:15px;
}

.login-link a{
    color:#0072ff;
    text-decoration:none;
}

/* Messages */
.success{
    color:#28a745;
    text-align:center;
}

.error{
    color:#dc3545;
    text-align:center;
}

/* 📱 MOBILE RESPONSIVE */
@media (max-width:600px){

    .container{
        padding:20px;
        border-radius:10px;
    }

    h2{
        font-size:18px;
    }

    input{
        padding:10px;
    }

    button{
        padding:10px;
    }

}

/* 📱 EXTRA SMALL DEVICE */
@media (max-width:400px){

    .container{
        padding:15px;
    }

    h2{
        font-size:16px;
    }

}
</style>
</head>

<body>

<div class="main-wrapper">

<div class="container">
<h2>🎓 Student Register</h2>

<form method="POST" enctype="multipart/form-data">

    <div class="input-group">
        <label>Full Name</label>
        <input name="name" placeholder="Enter your name" required>
    </div>

    <div class="input-group">
        <label>Email</label>
        <input name="email" type="email" placeholder="Enter your email" required>
    </div>

    <div class="input-group">
        <label>CGPA</label>
        <input name="cgpa" type="number" step="0.01" placeholder="0 - 10" required>
    </div>

    <div class="input-group">
        <label>Skills</label>
        <input name="skills" placeholder="HTML, CSS, Java" required>
    </div>

    <div class="input-group">
        <label>Upload Resume</label>
        <input type="file" name="resume" required>
    </div>

    <div class="input-group">
        <label>Password</label>
        <input name="password" type="password" placeholder="Enter password" required>
    </div>

    <button name="reg">Register</button>

</form>

<p class="login-link">
Already have account? <a href="student_login.php">Login</a>
</p>

</div>

</div>

</body>
</html>