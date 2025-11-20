<?php
session_start();
if($_SESSION['role'] != 'siswa'){
    header("Location: ../../index.php");
    exit();
}

include "../../config.php";
include "../../helpers/auth_helper.php";

$id_user   = $_SESSION['id'];
$username  = $_SESSION['username'];
$id_siswa = getSiswaId($conn);
if(!$id_siswa){
    header("Location: ../../index.php");
    exit();
}

// ambil info siswa dari tabel siswa
$q = mysqli_query($conn, 
"SELECT siswa.*, kelas.nama_kelas 
 FROM siswa 
 JOIN kelas ON kelas.id = siswa.id_kelas
 JOIN users ON users.id_siswa = siswa.id
 WHERE users.id='$id_user'");

$siswa = mysqli_fetch_assoc($q);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Siswa</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>

<h2>Selamat Datang, <?= $siswa['nama_lengkap']; ?>!</h2>
<p>Kelas: <?= $siswa['nama_kelas']; ?></p>

<div class="menu-grid">

    <a href="jadwal.php" class="menu-card">
        <h3>Jadwal Pelajaran</h3>
        <p>Lihat jadwal belajar harian</p>
    </a>

    <a href="materi.php" class="menu-card">
        <h3>Materi Pelajaran</h3>
        <p>Lihat materi dari guru</p>
    </a>

    <a href="tugas.php" class="menu-card">
        <h3>Tugas</h3>
        <p>Lihat & upload tugas</p>
    </a>

    <a href="nilai.php" class="menu-card">
        <h3>Nilai</h3>
        <p>Lihat nilai tugas anda</p>
    </a>

    <a href="absensi.php" class="menu-card">
        <h3>Absensi</h3>
        <p>Lihat rekap absensi anda</p>
    </a>

</div>

</div>

</body>
</html>
