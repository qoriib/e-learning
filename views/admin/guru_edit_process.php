<?php
session_start();
include "../../config.php";
include "../../log.php";

$id     = $_POST['id'];
$nip    = $_POST['nip'];
$nama   = $_POST['nama'];
$email  = $_POST['email'];
$telp   = $_POST['telp'];
$username = trim($_POST['username']);

mysqli_query($conn, "UPDATE guru SET 
    nip='$nip', 
    nama_lengkap='$nama',
    email='$email',
    no_telp='$telp'
WHERE id='$id'");

// UPDATE username guru di tabel users
if($username !== ''){
    mysqli_query($conn, "UPDATE users SET username='$username' WHERE id_guru='$id'");
} else {
    mysqli_query($conn, "UPDATE users SET username='$nip' WHERE id_guru='$id'");
}

catat_log($conn, "Admin mengedit data guru: $nama");

header("Location: guru.php");
?>
