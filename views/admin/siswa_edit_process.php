<?php
session_start();
include "../../config.php";
include "../../log.php";

$id    = $_POST['id'];
$nis   = $_POST['nis'];
$nama  = $_POST['nama'];
$email = $_POST['email'];
$telp  = $_POST['telp'];
$kelas = $_POST['kelas'];
$username = trim($_POST['username']);

// Update data siswa
mysqli_query($conn, "UPDATE siswa SET 
    nis='$nis',
    nama_lengkap='$nama',
    email='$email',
    no_telp='$telp',
    id_kelas='$kelas'
WHERE id='$id'");

// update username siswa
if($username !== ''){
    mysqli_query($conn, "UPDATE users SET username='$username' WHERE id_siswa='$id'");
} else {
    mysqli_query($conn, "UPDATE users SET username='$nis' WHERE id_siswa='$id'");
}

catat_log($conn, "Admin mengedit data siswa: $nama");

header("Location: siswa.php");
?>
