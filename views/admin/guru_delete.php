<?php
session_start();
include "../../config.php";

$id = $_GET['id'];

// hapus pengguna (users)
mysqli_query($conn, "DELETE FROM users WHERE id_guru='$id'");

// hapus data guru
mysqli_query($conn, "DELETE FROM guru WHERE id='$id'");

header("Location: guru.php");
?>
