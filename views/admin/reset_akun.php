<?php
session_start();
if($_SESSION['role'] != 'admin'){
    header("Location: ../../index.php");
    exit();
}

include "../../config.php";
include "../../log.php";
?>

<!DOCTYPE html>
<html>
<head>
<title>Reset Akun Pengguna</title>
<link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">

<?php include "header.php"; ?>

<div class="card">
<h2>Reset Akun Guru & Siswa</h2>

<p>Pilih akun guru atau siswa yang ingin direset passwordnya.</p>
<br>

<h3>Reset Akun Guru</h3>
<table class="tabel">
    <tr>
        <th>No</th>
        <th>NIP</th>
        <th>Nama</th>
        <th>Aksi</th>
    </tr>

<?php
$no = 1;
$guru = mysqli_query($conn, 
    "SELECT guru.id, guru.nip, guru.nama_lengkap, users.id AS id_user
     FROM guru
     JOIN users ON users.id_guru = guru.id
     ORDER BY guru.nama_lengkap ASC");

while($g = mysqli_fetch_assoc($guru)){
?>
<tr>
    <td><?= $no++; ?></td>
    <td><?= $g['nip']; ?></td>
    <td><?= $g['nama_lengkap']; ?></td>
    <td>
        <a href="reset_akun_process.php?role=guru&id=<?= $g['id_user']; ?>"
           onclick="return confirm('Reset password guru ini?')">
            Reset Password
        </a>
    </td>
</tr>
<?php } ?>
</table>

<br><br>

<h3>Reset Akun Siswa</h3>
<table class="tabel">
    <tr>
        <th>No</th>
        <th>NIS</th>
        <th>Nama</th>
        <th>Aksi</th>
    </tr>

<?php
$no = 1;
$siswa = mysqli_query($conn, 
    "SELECT siswa.id, siswa.nis, siswa.nama_lengkap, users.id AS id_user
     FROM siswa
     JOIN users ON users.id_siswa = siswa.id
     ORDER BY siswa.nama_lengkap ASC");

while($s = mysqli_fetch_assoc($siswa)){
?>
<tr>
    <td><?= $no++; ?></td>
    <td><?= $s['nis']; ?></td>
    <td><?= $s['nama_lengkap']; ?></td>
    <td>
        <a href="reset_akun_process.php?role=siswa&id=<?= $s['id_user']; ?>"
           onclick="return confirm('Reset password siswa ini?')">
            Reset Password
        </a>
    </td>
</tr>
<?php } ?>
</table>

</div>
</div>
</body>
</html>
