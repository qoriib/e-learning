<?php
session_start();
include "../../config.php";

$nama  = $_POST['nama'];
$tahun = $_POST['tahun'];

mysqli_query($conn, "INSERT INTO kelas (nama_kelas, id_tahun_ajaran)
VALUES ('$nama', '$tahun')");

header("Location: kelas.php");
?>
