<?php 
include 'config.php';

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:#eef2f7;
}

/* CONTAINER */
.container{
    width:90%;
    margin:20px auto;
}

/* 🔥 TOPBAR */
.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:#fff;
    padding:15px 20px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

.topbar h2{
    margin:0;
    color:#2c3e50;
}

/* LOGOUT BUTTON */
.logout-btn{
    text-decoration:none;
    padding:10px 18px;
    background:linear-gradient(45deg,#ff4b2b,#ff416c);
    color:#fff;
    border-radius:8px;
    font-weight:600;
    transition:0.3s;
    box-shadow:0 5px 12px rgba(0,0,0,0.15);
}

.logout-btn:hover{
    transform:translateY(-2px);
}

/* CARDS */
.stats{
    display:flex;
    gap:20px;
    justify-content:center;
    flex-wrap:wrap;
    margin-top:20px;
}

.card{
    background:linear-gradient(135deg,#0072ff,#00c6ff);
    padding:20px;
    border-radius:12px;
    color:#fff;
    width:140px;
    text-align:center;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.card b{
    font-size:20px;
}

/* CHART */
canvas{
    margin-top:30px;
    background:#fff;
    padding:20px;
    border-radius:12px;
}

/* TABLE */
.table-box{
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse: collapse;
    margin-top:20px;
    background:#fff;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

th{
    background:#0072ff;
    color:#fff;
    padding:12px;
}

td{
    padding:10px;
    text-align:center;
    border-bottom:1px solid #eee;
}

tr:hover{
    background:#f5f9ff;
}

/* BUTTON LINKS */
a{
    text-decoration:none;
    font-weight:600;
}

.approve{ color:#28a745; }
.reject{ color:#dc3545; }

/* RESPONSIVE */
@media(max-width:768px){

    .topbar{
        flex-direction:column;
        gap:10px;
    }

    table,thead,tbody,th,td,tr{
        display:block;
    }

    th{ display:none; }

    tr{
        margin-bottom:15px;
        padding:10px;
        background:#fff;
        border-radius:10px;
    }

    td{
        text-align:left;
        padding:8px;
    }

}
</style>

</head>
<body>

<div class="container">

<!-- 🔥 TOPBAR -->
<div class="topbar">
    <h2>Admin Dashboard</h2>
    <a href="logout.php" class="logout-btn">Logout</a>
</div>

<hr>

<!-- 📊 STATS -->
<h3 style="text-align:center;">📊 Application Overview</h3>

<?php
$total = $conn->query("SELECT COUNT(*) FROM applications")->fetch_row()[0];
$pending = $conn->query("SELECT COUNT(*) FROM applications WHERE status='Pending'")->fetch_row()[0];
$approved = $conn->query("SELECT COUNT(*) FROM applications WHERE status='Approved'")->fetch_row()[0];
$rejected = $conn->query("SELECT COUNT(*) FROM applications WHERE status='Rejected'")->fetch_row()[0];
?>

<div class="stats">
    <div class="card">Total<br><b><?= $total ?></b></div>
    <div class="card">Pending<br><b><?= $pending ?></b></div>
    <div class="card">Approved<br><b><?= $approved ?></b></div>
    <div class="card">Rejected<br><b><?= $rejected ?></b></div>
</div>

<canvas id="chart"></canvas>

<script>
new Chart(document.getElementById('chart'),{
type:'bar',
data:{
labels:['Total','Pending','Approved','Rejected'],
datasets:[{
data:[<?= $total ?>,<?= $pending ?>,<?= $approved ?>,<?= $rejected ?>]
}]
}
});
</script>

<hr>

<!-- 📄 APPLICATION TABLE -->
<h3 style="text-align:center;">📄 All Applications</h3>

<div class="table-box">
<table>
<tr>
<th>Student</th>
<th>Email</th>
<th>CGPA</th>
<th>Job</th>
<th>Company</th>
<th>Status</th>
<th>Resume</th>
<th>Action</th>
</tr>

<?php
$query = "
SELECT a.id, s.name, s.email, s.cgpa, s.resume,
       j.title, c.name AS company, a.status
FROM applications a
JOIN students s ON a.student_id = s.id
JOIN jobs j ON a.job_id = j.id
JOIN companies c ON j.company_id = c.id
";

$res = $conn->query($query);

while($row = $res->fetch_assoc()){
?>
<tr>
<td><?= $row['name'] ?></td>
<td><?= $row['email'] ?></td>
<td><?= $row['cgpa'] ?></td>
<td><?= $row['title'] ?></td>
<td><?= $row['company'] ?></td>
<td><?= $row['status'] ?></td>

<td>
<a href="uploads/<?= $row['resume'] ?>" download>Download</a>
</td>

<td>
<a href="update_status.php?id=<?= $row['id'] ?>&s=Approved" class="approve">Approve</a> |
<a href="update_status.php?id=<?= $row['id'] ?>&s=Rejected" class="reject">Reject</a>
</td>

</tr>
<?php } ?>

</table>
</div>

</div>

</body>
</html>