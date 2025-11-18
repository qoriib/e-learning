<?php
session_start();
include "../../config.php";

$id   = $_POST['id'];
$nama = $_POST['nama'];

mysqli_query($conn, "UPDATE mapel SET nama_mapel='$nama' WHERE id='$id'");

header("Location: mapel.php");
?>
