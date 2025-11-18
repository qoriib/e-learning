<?php
session_start();
if($_SESSION['role'] != 'guru'){
    header("Location: ../../index.php");
    exit();
}
include "../../config.php";
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard Guru</title>
<link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>

<h2>Dashboard Guru</h2>

<div class="menu-grid">

    <a href="absen_guru.php" class="menu-card">
        <h3>Absensi Guru</h3>
        <p>Absensi harian anda</p>
    </a>

    <a href="absen_siswa.php" class="menu-card">
        <h3>Absensi Siswa</h3>
        <p>Absensi siswa per kelas</p>
    </a>

    <a href="materi.php" class="menu-card">
        <h3>Materi</h3>
        <p>Upload & kelola materi</p>
    </a>

    <a href="tugas.php" class="menu-card">
        <h3>Tugas</h3>
        <p>Buat & kelola tugas</p>
    </a>

    <a href="nilai.php" class="menu-card">
        <h3>Penilaian</h3>
        <p>Lihat dan beri nilai tugas</p>
    </a>

    <a href="laporan.php" class="menu-card">
        <h3>Laporan</h3>
        <p>Upload laporan untuk admin</p>
    </a>

    <a href="jadwal.php" class="menu-card">
        <h3>Jadwal Mengajar</h3>
        <p>Lihat roster yang ditugaskan admin</p>
    </a>

</div>

</div>

</body>
</html>
