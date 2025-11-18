<?php
session_start();
include "../../config.php";

$id    = $_POST['id'];
$nama  = $_POST['nama'];
$tahun = $_POST['tahun'];

mysqli_query($conn, "UPDATE kelas SET
    nama_kelas='$nama',
    id_tahun_ajaran='$tahun'
WHERE id='$id'");

header("Location: kelas.php");
?>
