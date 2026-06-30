<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Placement System</title>

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background: linear-gradient(135deg,#f4f6f9,#e9eef5);
}

/* HEADER */
.header{
    text-align:center;
    padding:40px 20px;
}

.header h2{
    margin:0;
    font-size:32px;
    color:#2c3e50;
}

.header p{
    color:#666;
    margin-top:8px;
}

/* CARD WRAPPER */
.container{
    display:flex;
    justify-content:center;
    flex-wrap:wrap;
    gap:20px;
    padding:20px;
}

/* CARD */
.card{
    width:220px;
    background:#fff;
    padding:25px;
    border-radius:12px;
    text-align:center;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

/* ICON STYLE */
.icon{
    font-size:40px;
    margin-bottom:10px;
}

/* LINKS */
a{
    display:block;
    margin-top:10px;
    padding:10px;
    border-radius:8px;
    text-decoration:none;
    color:#fff;
    font-weight:600;
}

/* COLORS */
.register{background:#0072ff;}
.student{background:#28a745;}
.company{background:#ff9800;}
.admin{background:#e74c3c;}

/* FOOTER */
.footer{
    text-align:center;
    margin-top:30px;
    color:#555;
    font-size:14px;
    padding:30px 20px;
    background:#ffffff;
}

/* RESPONSIVE */
@media(max-width:600px){
    .card{
        width:90%;
    }
}
</style>

</head>

<body>

<div class="header">
    <h2>🎓 Placement System</h2>
    <p>Choose your role to continue</p>
</div>

<div class="container">

    <div class="card">
        <div class="icon">📝</div>
        <h3> Student Registration</h3>
        <a href="student_register.php" class="register">Create Account</a>
    </div>

    <div class="card">
        <div class="icon">🎓</div>
        <h3>Student</h3>
        <a href="student_login.php" class="student">Login</a>
    </div>

    <div class="card">
        <div class="icon">🏢</div>
        <h3>Company</h3>
        <a href="company_login.php" class="company">Login</a>
    </div>

    <div class="card">
        <div class="icon">🛡️</div>
        <h3>Admin</h3>
        <a href="admin.php" class="admin">Login</a>
    </div>

</div>

<!-- 🔥 PROFESSIONAL FOOTER -->
<div class="footer">

    <p><b>About Us</b></p>
    <p>
    Placement System is a modern campus recruitment platform that connects students,
    companies, and administrators in a single ecosystem. Students can explore job
    opportunities, companies can find the right talent, and administrators can manage
    the entire hiring process efficiently.
    </p>

    <br>

    <p><b>Contact Us</b></p>
    <p>
    📧 Email: support@placementsystem.com <br>
    📞 Phone: +91 98765 43210 <br>
    📍 Location: Barasat, Kolkata-700124, India
    </p>

    <br>

    <p>© 2026 Placement System | Built for Campus Recruitment</p>

</div>

</body>
</html>