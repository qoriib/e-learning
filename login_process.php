<?php
session_start();
include "config.php";
include "log.php";

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = $_POST['password'];

$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' LIMIT 1");
$user = mysqli_fetch_assoc($query);

if(!$user){
    header("Location: index.php?error=Username tidak ditemukan");
    exit();
}

if($user['status'] == 'non-aktif'){
    header("Location: index.php?error=Akun ini non-aktif");
    exit();
}

if(!password_verify($password, $user['password'])){
    header("Location: index.php?error=Password salah");
    exit();
}

$_SESSION['id'] = $user['id'];
$_SESSION['role'] = $user['role'];
$_SESSION['username'] = $user['username'];

catat_log($conn, "Login ke sistem");

if($user['role'] == 'admin'){
    header("Location: views/admin/dashboard.php");
} elseif($user['role'] == 'guru'){
    header("Location: views/guru/dashboard.php");
} elseif($user['role'] == 'siswa'){
    header("Location: views/siswa/dashboard.php");
}

exit();
?>
