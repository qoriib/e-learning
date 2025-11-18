<?php
session_start();
include "../../config.php";
include "../../log.php";

$id = $_GET['id'];

$q = mysqli_query($conn, "SELECT file_path FROM tugas WHERE id='$id'");
$d = mysqli_fetch_assoc($q);

if($d['file_path'] && file_exists($d['file_path'])){
    unlink($d['file_path']);
}

mysqli_query($conn, "DELETE FROM tugas WHERE id='$id'");

catat_log($conn, "Guru menghapus tugas ID: $id");

header("Location: tugas.php");
exit();
?>
