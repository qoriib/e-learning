<?php
session_start();
include "../../config.php";
include "../../log.php";

$id = $_GET['id'];

// ambil file
$q = mysqli_query($conn, "SELECT file_path FROM materi WHERE id='$id'");
$d = mysqli_fetch_assoc($q);

if(file_exists($d['file_path'])){
    unlink($d['file_path']);
}

mysqli_query($conn, "DELETE FROM materi WHERE id='$id'");

catat_log($conn, "Guru menghapus materi ID: $id");

header("Location: materi.php");
exit();
?>
