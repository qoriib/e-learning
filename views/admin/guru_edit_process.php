<?php
session_start();
include "../../config.php";

$id     = $_POST['id'];
$nip    = $_POST['nip'];
$nama   = $_POST['nama'];
$email  = $_POST['email'];
$telp   = $_POST['telp'];

mysqli_query($conn, "UPDATE guru SET 
    nip='$nip', 
    nama_lengkap='$nama',
    email='$email',
    no_telp='$telp'
WHERE id='$id'");

// UPDATE username guru di tabel users
mysqli_query($conn, "UPDATE users SET username='$nip' WHERE id_guru='$id'");

header("Location: guru.php");
?>
