<?php
include 'config.php';

$id = $_GET['id'];

$conn->query("DELETE FROM jobs WHERE id='$id'");

header("Location: company_dashboard.php");
?>