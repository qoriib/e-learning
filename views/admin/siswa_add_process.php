<?php
session_start();
include "../../config.php";
include "../../log.php";

$nis   = $_POST['nis'];
$nama  = $_POST['nama'];
$email = $_POST['email'];
$telp  = $_POST['telp'];
$kelas = $_POST['kelas'];
$username = trim($_POST['username']);

mysqli_query($conn, "INSERT INTO siswa (nis, nama_lengkap, email, no_telp, id_kelas)
VALUES ('$nis', '$nama', '$email', '$telp', '$kelas')");

$id_siswa = mysqli_insert_id($conn);

// buat akun login siswa
$username = $username !== '' ? $username : $nis;
$password = password_hash("password123", PASSWORD_DEFAULT);

mysqli_query($conn, "INSERT INTO users (username, password, role, id_siswa)
VALUES ('$username', '$password', 'siswa', '$id_siswa')");

catat_log($conn, "Admin menambah siswa baru: $nama");

header("Location: siswa.php");
?>
