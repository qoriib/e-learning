<?php
session_start();
include "../../config.php";
include "../../log.php"; // tambahkan ini !!

$nip = $_POST['nip'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$telp = $_POST['telp'];
$usernameInput = trim($_POST['username']);

// simpan ke tabel guru
mysqli_query($conn, "INSERT INTO guru (nip, nama_lengkap, email, no_telp)
VALUES ('$nip', '$nama', '$email', '$telp')");

// ambil ID guru yg baru ditambahkan
$id_guru = mysqli_insert_id($conn);

// BUAT AKUN LOGIN KE TABEL USERS
$username = $usernameInput !== '' ? $usernameInput : $nip;
$password = password_hash("password123", PASSWORD_DEFAULT); // default password

mysqli_query($conn, "INSERT INTO users (username, password, role, id_guru)
VALUES ('$username', '$password', 'guru', '$id_guru')");

// CATAT LOG AKTIVITAS
catat_log($conn, "Admin menambah guru baru: $nama");

// REDIRECT KE HALAMAN GURU
header("Location: guru.php");
exit(); // penting supaya aman
?>
