<?php
session_start();
include "../../config.php";
include "../../log.php";

$id_user = $_SESSION['id'];
$status  = $_POST['status'];
$ket     = $_POST['keterangan'];
$tanggal = date("Y-m-d");

mysqli_query($conn,
"INSERT INTO absensi (id_user, tanggal, status, keterangan, jenis_absen)
 VALUES ('$id_user', '$tanggal', '$status', '$ket', 'guru')");

catat_log($conn, "Guru melakukan absensi: $status");

header("Location: absen_guru.php");
exit();
?>
