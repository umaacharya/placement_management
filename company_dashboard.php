<?php 
include 'config.php';

if(!isset($_SESSION['company'])){
    header("Location: company_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Company Dashboard</title>

<style>
body{
    font-family:'Segoe UI',sans-serif;
    margin:0;
    background:#eef2f7;
}

/* TOPBAR */
.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 30px;
    background:#fff;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

.topbar h2{
    margin:0;
    color:#2c3e50;
}

/* LOGOUT */
.logout-btn{
    background:linear-gradient(45deg,#ff4d4d,#ff1a1a);
    color:#fff;
    padding:8px 18px;
    border-radius:20px;
    text-decoration:none;
    font-weight:500;
}

/* CONTAINER */
.container{
    width:95%;
    max-width:1100px;
    margin:20px auto;
}

/* CARD */
.card{
    background:#fff;
    padding:20px;
    margin-top:20px;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
}

/* FORM */
form{
    display:flex;
    flex-wrap:wrap;
    gap:12px;
    justify-content:center;
}

input, textarea{
    padding:10px;
    border:1px solid #ddd;
    border-radius:8px;
    width:260px;
    background:#f9f9f9;
}

textarea{ width:540px; }

/* BUTTON */
button{
    padding:10px 18px;
    border:none;
    border-radius:8px;
    background:linear-gradient(45deg,#0072ff,#00c6ff);
    color:#fff;
    cursor:pointer;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
    border-radius:10px;
    overflow:hidden;
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
    background:#f9fbff;
}

/* STATUS */
.status-pending{color:#ff9800;font-weight:600;}
.status-approved{color:#28a745;font-weight:600;}
.status-rejected{color:#dc3545;font-weight:600;}

/* ACTION BUTTONS */
.action-btns{
    display:flex;
    justify-content:center;
    gap:6px;
    flex-wrap:wrap;
}

.action-btns a{
    padding:6px 10px;
    border-radius:6px;
    font-size:12px;
    color:#fff;
    text-decoration:none;
}

.approve{background:#28a745;}
.reject{background:#dc3545;}
.schedule{background:#0072ff;}
.delete-btn{color:#dc3545;font-weight:bold;}

.success{
    text-align:center;
    color:#28a745;
}

/* RESPONSIVE */
@media(max-width:768px){

    form{
        flex-direction:column;
        align-items:center;
    }

    input, textarea{
        width:100%;
    }

    table,thead,tbody,th,td,tr{
        display:block;
    }

    th{display:none;}

    tr{
        background:#fff;
        margin-bottom:15px;
        padding:10px;
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

<!-- TOPBAR -->
<div class="topbar">
    <h2>🏢 Company Dashboard</h2>
    <a href="logout.php" class="logout-btn">Logout</a>
</div>

<div class="container">

<!-- POST JOB -->
<div class="card">
<h3> Post Job</h3>

<form method="POST">
<input name="title" placeholder="Job Title" required>
<textarea name="desc" placeholder="Job Description"></textarea>
<input name="elig" placeholder="CGPA Required">
<button name="post">Post Job</button>
</form>

<?php
if(isset($_POST['post'])){
    $cid=$_SESSION['company'];

    $conn->query("INSERT INTO jobs(company_id,title,description,eligibility)
    VALUES('$cid','$_POST[title]','$_POST[desc]','$_POST[elig]')");

    echo "<p class='success'>✅ Job Posted</p>";
}
?>
</div>

<!-- JOB LIST -->
<div class="card">
<h3> Posted Jobs</h3>

<table>
<tr>
<th>Title</th>
<th>Description</th>
<th>CGPA</th>
<th>Applied</th>
<th>Action</th>
</tr>

<?php
$cid=$_SESSION['company'];
$jobs=$conn->query("SELECT * FROM jobs WHERE company_id='$cid'");

while($job=$jobs->fetch_assoc()){
$jid=$job['id'];
$count=$conn->query("SELECT COUNT(*) FROM applications WHERE job_id='$jid'")->fetch_row()[0];
?>

<tr>
<td><?= $job['title'] ?></td>
<td><?= $job['description'] ?></td>
<td><?= $job['eligibility'] ?></td>
<td><?= $count ?></td>

<td>
<a class="delete-btn" href="delete_job.php?id=<?= $jid ?>">Delete</a>
</td>
</tr>

<?php } ?>
</table>
</div>

<!-- APPLICATIONS -->
<div class="card">
<h3>👨‍🎓 Applications</h3>

<table>
<tr>
<th>Name</th>
<th>Email</th>
<th>CGPA</th>
<th>Job</th>
<th>Status</th>
<th>Interview</th>
<th>Resume</th>
<th>Action</th>
</tr>

<?php
$query="
SELECT a.id, s.name, s.email, s.cgpa, s.resume,
j.title, a.status, a.interview_date
FROM applications a
JOIN students s ON a.student_id=s.id
JOIN jobs j ON a.job_id=j.id
WHERE j.company_id='$cid'
";

$res=$conn->query($query);

while($row=$res->fetch_assoc()){
?>

<tr>
<td><?= $row['name'] ?></td>
<td><?= $row['email'] ?></td>
<td><?= $row['cgpa'] ?></td>
<td><?= $row['title'] ?></td>

<td>
<?php
if($row['status']=="Pending"){
echo "<span class='status-pending'>Pending</span>";
}elseif($row['status']=="Approved"){
echo "<span class='status-approved'>Approved</span>";
}else{
echo "<span class='status-rejected'>Rejected</span>";
}
?>
</td>

<td>
<?php
if(!empty($row['interview_date'])){
echo date("d M Y h:i A", strtotime($row['interview_date']));
}else{
echo "-";
}
?>
</td>

<td>
<a href="uploads/<?= $row['resume'] ?>" download>Download</a>
</td>

<td>
<div class="action-btns">

<a href="company_action.php?id=<?= $row['id'] ?>&s=Approved" class="approve">Approve</a>

<a href="company_action.php?id=<?= $row['id'] ?>&s=Rejected" class="reject">Reject</a>

<?php if($row['status']=="Approved"){ ?>
<a href="schedule.php?id=<?= $row['id'] ?>" class="schedule">Schedule</a>
<?php } ?>

</div>
</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>