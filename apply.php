<?php include 'config.php';
$sid=$_SESSION['student'];
$jid=$_GET['id'];
$check=$conn->query("SELECT * FROM applications WHERE student_id='$sid' AND job_id='$jid'");
if($check->num_rows>0){ echo "Already Applied"; exit(); }
$conn->query("INSERT INTO applications(student_id,job_id) VALUES('$sid','$jid')");
echo "Applied";
?>