<?php
session_start();
include "../../config.php";

$id       = $_POST['id'];
$tahun    = $_POST['tahun'];
$semester = $_POST['semester'];

mysqli_query($conn, 
    "UPDATE tahun_ajaran SET tahun='$tahun', semester='$semester' WHERE id='$id'"
);

header("Location: tahun_ajaran.php");
?>
