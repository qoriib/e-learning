<?php
session_start();
include "../../config.php";

$id = $_GET['id'];

// hapus akun login siswa
mysqli_query($conn, "DELETE FROM users WHERE id_siswa='$id'");

// hapus data siswa
mysqli_query($conn, "DELETE FROM siswa WHERE id='$id'");

header("Location: siswa.php");
?>
