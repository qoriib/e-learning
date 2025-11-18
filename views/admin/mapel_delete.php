<?php
session_start();
include "../../config.php";

$id = $_GET['id'];

// cek jika mapel digunakan oleh roster
$cek_roster = mysqli_query($conn, "SELECT * FROM roster WHERE id_mapel='$id'");
if(mysqli_num_rows($cek_roster) > 0){
    echo "<script>alert('Tidak bisa menghapus mapel karena digunakan di roster!');window.location='mapel.php';</script>";
    exit();
}

// cek materi
$cek_materi = mysqli_query($conn, "SELECT * FROM materi WHERE id_mapel='$id'");
if(mysqli_num_rows($cek_materi) > 0){
    echo "<script>alert('Tidak bisa menghapus mapel karena digunakan oleh materi guru!');window.location='mapel.php';</script>";
    exit();
}

mysqli_query($conn, "DELETE FROM mapel WHERE id='$id'");

header("Location: mapel.php");
?>
