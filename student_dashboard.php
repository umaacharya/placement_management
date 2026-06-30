<?php 
include 'config.php';

if(!isset($_SESSION['student'])){
    header("Location: student_login.php");
    exit();
}

$id=$_SESSION['student'];
$data=$conn->query("SELECT * FROM students WHERE id='$id'")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Dashboard</title>

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:#eef2f7;
}

.main{ padding:20px; }

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:#ffffff;
    padding:15px 25px;
    border-radius:12px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
}

.logout{
    background:#dc3545;
    color:#fff;
    padding:8px 15px;
    border-radius:6px;
    text-decoration:none;
}

.card{
    background:#ffffff;
    margin-top:20px;
    padding:20px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

.skill-tag{
    display:inline-block;
    background:#0d6efd;
    color:#fff;
    padding:5px 12px;
    margin:5px;
    border-radius:20px;
    font-size:12px;
}

.btn{
    display:inline-block;
    padding:8px 14px;
    margin-top:10px;
    background:#0d6efd;
    color:#fff;
    border-radius:6px;
    text-decoration:none;
}

.call-btn{ background:#198754; }
.join-btn{ background:#6f42c1; }

input{
    width:100%;
    padding:10px;
    margin:8px 0;
    border-radius:6px;
    border:1px solid #ccc;
}

button{
    width:100%;
    padding:10px;
    background:#198754;
    color:#fff;
    border:none;
    border-radius:6px;
}

.success{ color:#198754; margin-top:10px; }

.table-box{ overflow-x:auto; }

table{
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
}

th{
    background:#0d6efd;
    color:#fff;
    padding:12px;
}

td{
    padding:12px;
    text-align:center;
    background:#fff;
    border-bottom:1px solid #eee;
}

tr:hover td{ background:#f1f6ff; }

.badge{
    padding:5px 10px;
    border-radius:20px;
    font-size:12px;
    color:#fff;
}

.pending{ background:#ffc107; color:#000; }
.approved{ background:#198754; }
.rejected{ background:#dc3545; }

.interview{
    font-size:13px;
    margin-bottom:5px;
    color:#555;
}

@media(max-width:768px){
    .topbar{ flex-direction:column; gap:10px; }
    table,thead,tbody,th,td,tr{ display:block; }
    th{ display:none; }
    tr{
        margin-bottom:15px;
        background:#fff;
        border-radius:10px;
        padding:10px;
    }
    td{ text-align:left; }
}
</style>

</head>
<body>

<div class="main">

<!-- TOPBAR -->
<div class="topbar">
<h2>🎓 Student Dashboard</h2>
<a href="logout.php" class="logout">Logout</a>
</div>

<!-- PROFILE -->
<div class="card">
<h3><?= $data['name'] ?></h3>
<p><?= $data['email'] ?></p>
<p>CGPA: <?= $data['cgpa'] ?></p>

<div>
<?php 
if(!empty($data['skills'])){
    foreach(explode(",",$data['skills']) as $s){
        echo "<span class='skill-tag'>".trim($s)."</span>";
    }
}else{
    echo "No Skills";
}
?>
</div>

<a href="edit_profile.php" class="btn">Edit Profile</a>
<a href="uploads/<?= $data['resume'] ?>" class="btn">Download CV</a>
</div>

<!-- UPDATE CV -->
<div class="card">
<h3>📄 Update CV</h3>

<form method="POST" enctype="multipart/form-data">
<input type="file" name="cv" required>
<button name="cvbtn">Update CV</button>
</form>

<?php
if(isset($_POST['cvbtn'])){
$f=time()."_".$_FILES['cv']['name'];
move_uploaded_file($_FILES['cv']['tmp_name'],"uploads/".$f);
$conn->query("UPDATE students SET resume='$f' WHERE id='$id'");
echo "<div class='success'>✅ Updated</div>";
}
?>
</div>

<!-- 🔥 JOB LIST -->
<div class="card">
<h3>💼 Available Jobs</h3>

<form method="GET">
<input name="search" placeholder="Search job...">
<button>Search</button>
</form>

<div class="table-box">
<table>
<tr>
<th>Company</th>
<th>Job</th>
<th>Description</th>
<th>CGPA</th>
<th>Action</th>
</tr>

<?php
$search=$_GET['search']??'';

$jobs=$conn->query("
SELECT j.*,c.name cname 
FROM jobs j 
JOIN companies c ON j.company_id=c.id
WHERE j.title LIKE '%$search%'");

while($j=$jobs->fetch_assoc()){
$jid=$j['id'];

$check=$conn->query("
SELECT * FROM applications 
WHERE student_id='$id' AND job_id='$jid'");
?>

<tr>
<td><?= $j['cname'] ?></td>
<td><?= $j['title'] ?></td>
<td><?= $j['description'] ?></td>
<td><?= $j['eligibility'] ?></td>

<td>
<?php
if($check->num_rows>0){
echo "<span class='badge approved'>Applied</span>";
}else{
?>
<a href="?apply=<?= $jid ?>" class="btn">Apply</a>
<?php } ?>
</td>

</tr>

<?php } ?>
</table>
</div>
</div>

<?php
if(isset($_GET['apply'])){
$conn->query("INSERT INTO applications(student_id,job_id,status) VALUES('$id','$_GET[apply]','Pending')");
echo "<div class='success'>✅ Applied Successfully</div>";
}
?>

<!-- APPLICATION STATUS -->
<div class="card">
<h3>📊 Application Status</h3>

<div class="table-box">
<table>
<tr>
<th>Company</th>
<th>Job</th>
<th>Status</th>
<th>Interview</th>
<th>Action</th>
</tr>

<?php
$res=$conn->query("
SELECT j.title,c.name cname,a.status,a.interview_date,a.interview_link
FROM applications a
JOIN jobs j ON a.job_id=j.id
JOIN companies c ON j.company_id=c.id
WHERE a.student_id='$id'");

while($r=$res->fetch_assoc()){
?>

<tr>
<td><?= $r['cname'] ?></td>
<td><?= $r['title'] ?></td>

<td>
<?php
if($r['status']=="Pending") echo "<span class='badge pending'>Pending</span>";
elseif($r['status']=="Approved") echo "<span class='badge approved'>Approved</span>";
else echo "<span class='badge rejected'>Rejected</span>";
?>
</td>

<td>
<?php
if($r['status']=="Approved"){
if(!empty($r['interview_date'])){
echo "<div class='interview'>📅 ".date("d M Y, h:i A", strtotime($r['interview_date']))."</div>";
}else{
echo "<div class='interview'>Not Scheduled</div>";
}
}else{ echo "-"; }
?>
</td>

<td>
<?php if($r['status']=="Approved"){ ?>

<a href="tel:+919876543210" class="btn call-btn">📞 Call HR</a>

<?php if(!empty($r['interview_link'])){ ?>
<a href="<?= $r['interview_link'] ?>" target="_blank" class="btn join-btn">🎥 Join Interview</a>
<?php } ?>

<?php } else { echo "-"; } ?>
</td>

</tr>

<?php } ?>
</table>
</div>

</div>

</div>
</body>
</html>