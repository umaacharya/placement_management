<?php
include 'config.php';

$id = $_GET['id'];

if(isset($_POST['save'])){
    $date = $_POST['date'];
    $link = $_POST['link'];

    $conn->query("UPDATE applications 
    SET interview_date='$date', interview_link='$link' 
    WHERE id='$id'");

    echo "<script>alert('Interview Scheduled');window.location='company_dashboard.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Schedule Interview</title>

<style>
body{
    font-family:'Segoe UI',sans-serif;
    margin:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background: linear-gradient(135deg,#667eea,#764ba2);
}

/* GLASS CARD */
.card{
    width:380px;
    padding:30px;
    border-radius:15px;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(15px);
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
    color:#fff;
    text-align:center;
}

/* TITLE */
h2{
    margin-bottom:20px;
}

/* INPUT GROUP */
.input-group{
    text-align:left;
    margin-bottom:15px;
}

label{
    font-size:13px;
    opacity:0.9;
}

/* INPUT */
input{
    width:100%;
    padding:12px;
    margin-top:5px;
    border:none;
    border-radius:8px;
    outline:none;
    background:rgba(255,255,255,0.2);
    color:#fff;
    transition:0.3s;
}

input::placeholder{
    color:#eee;
}

input:focus{
    background:rgba(255,255,255,0.3);
}

/* BUTTON */
button{
    width:100%;
    padding:12px;
    margin-top:10px;
    border:none;
    border-radius:8px;
    background:linear-gradient(45deg,#00c6ff,#0072ff);
    color:#fff;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    transform:translateY(-2px);
    box-shadow:0 5px 15px rgba(0,0,0,0.2);
}

/* BACK BUTTON */
.back{
    display:block;
    margin-top:15px;
    text-decoration:none;
    color:#fff;
    opacity:0.8;
}

.back:hover{
    opacity:1;
}

/* RESPONSIVE */
@media(max-width:480px){
    .card{
        width:90%;
        padding:20px;
    }
}
</style>

</head>
<body>

<div class="card">
<h2>📅 Schedule Interview</h2>

<form method="POST">

<div class="input-group">
<label>Interview Date & Time</label>
<input type="datetime-local" name="date" required>
</div>

<div class="input-group">
<label>Meeting Link</label>
<input type="text" name="link" placeholder="Zoom / Google Meet link">
</div>

<button name="save">Save Schedule</button>

</form>

<a href="company_dashboard.php" class="back">← Back to Dashboard</a>

</div>

</body>
</html>