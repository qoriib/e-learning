<?php
session_start();
include "../../config.php";

$nama = $_POST['nama'];

mysqli_query($conn, "INSERT INTO mapel (nama_mapel) VALUES ('$nama')");

header("Location: mapel.php");
?>
