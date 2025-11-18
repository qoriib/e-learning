<?php
session_start();
include "../../config.php";
include "../../log.php";

$id_user = $_GET['id'];
$role    = $_GET['role'];

$default_pass = password_hash("password123", PASSWORD_DEFAULT);

mysqli_query($conn, "UPDATE users SET password='$default_pass' WHERE id='$id_user'");

// catat log aktivitas
catat_log($conn, "Admin mereset password akun $role dengan ID user: $id_user");

header("Location: reset_akun.php");
exit();
?>
