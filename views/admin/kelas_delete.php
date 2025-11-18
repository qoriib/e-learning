<?php
session_start();
include "../../config.php";

$id = $_GET['id'];

// cek apakah kelas digunakan oleh siswa
$cek_siswa = mysqli_query($conn, "SELECT * FROM siswa WHERE id_kelas='$id'");
if(mysqli_num_rows($cek_siswa) > 0){
    echo "<script>alert('Tidak bisa menghapus kelas karena masih ada siswa!');window.location.href='kelas.php';</script>";
    exit();
}

// cek roster (jadwal)
$cek_roster = mysqli_query($conn, "SELECT * FROM roster WHERE id_kelas='$id'");
if(mysqli_num_rows($cek_roster) > 0){
    echo "<script>alert('Tidak bisa menghapus kelas karena digunakan pada roster!');window.location.href='kelas.php';</script>";
    exit();
}

mysqli_query($conn, "DELETE FROM kelas WHERE id='$id'");
header("Location: kelas.php");
?>
