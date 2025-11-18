<?php
session_start();
include "../../config.php";

$id = $_GET['id'];

// cek apakah digunakan oleh kelas
$cek_kelas = mysqli_query($conn, "SELECT * FROM kelas WHERE id_tahun_ajaran='$id'");
if(mysqli_num_rows($cek_kelas) > 0){
    echo "<script>alert('Tidak bisa hapus! Tahun ajaran dipakai oleh kelas.');window.location='tahun_ajaran.php';</script>";
    exit();
}

mysqli_query($conn, "DELETE FROM tahun_ajaran WHERE id='$id'");

header("Location: tahun_ajaran.php");
?>
