<?php
include 'config.php';

$id = $_GET['id'];
$status = $_GET['s'];

$conn->query("UPDATE applications SET status='$status' WHERE id='$id'");

header("Location: company_dashboard.php");
?>