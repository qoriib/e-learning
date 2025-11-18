<?php
session_start();
include "../../config.php";

$tahun = $_POST['tahun'];
$semester = $_POST['semester'];

mysqli_query($conn, "INSERT INTO tahun_ajaran (tahun, semester) 
VALUES('$tahun', '$semester')");

header("Location: tahun_ajaran.php");
?>
