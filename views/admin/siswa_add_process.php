<?php
session_start();
include "../../config.php";

$nis   = $_POST['nis'];
$nama  = $_POST['nama'];
$email = $_POST['email'];
$telp  = $_POST['telp'];
$kelas = $_POST['kelas'];

mysqli_query($conn, "INSERT INTO siswa (nis, nama_lengkap, email, no_telp, id_kelas)
VALUES ('$nis', '$nama', '$email', '$telp', '$kelas')");

$id_siswa = mysqli_insert_id($conn);

// buat akun login siswa
$username = $nis;
$password = password_hash("password123", PASSWORD_DEFAULT);

mysqli_query($conn, "INSERT INTO users (username, password, role, id_siswa)
VALUES ('$username', '$password', 'siswa', '$id_siswa')");

header("Location: siswa.php");
?>
