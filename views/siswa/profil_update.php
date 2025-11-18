<?php
session_start();
include "../../config.php";

$id_siswa = $_POST['id_siswa'];
$nama     = $_POST['nama'];
$email    = $_POST['email'];
$telp     = $_POST['telp'];

mysqli_query($conn,
"UPDATE siswa SET 
    nama_lengkap='$nama',
    email='$email',
    no_telp='$telp'
 WHERE id='$id_siswa'");

header("Location: profil.php?success=1");
exit();
?>
