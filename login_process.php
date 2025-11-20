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
$_SESSION['user_id'] = $user['id']; // simpan id pengguna untuk kebutuhan log
unset($_SESSION['guru_id'], $_SESSION['siswa_id']);

if($user['role'] == 'guru' && !empty($user['id_guru'])){
    $_SESSION['guru_id'] = $user['id_guru'];
} elseif($user['role'] == 'siswa' && !empty($user['id_siswa'])){
    $_SESSION['siswa_id'] = $user['id_siswa'];
}
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
