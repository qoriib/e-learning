<?php
session_start();
include "../../config.php";

$id = $_GET['id'];

// nonaktifkan semua
mysqli_query($conn, "UPDATE tahun_ajaran SET is_active = 0");

// aktifkan satu
mysqli_query($conn, "UPDATE tahun_ajaran SET is_active = 1 WHERE id='$id'");

header("Location: tahun_ajaran.php");
?>
