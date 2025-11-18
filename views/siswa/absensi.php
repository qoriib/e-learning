<?php
session_start();
if($_SESSION['role'] != 'siswa'){
    header("Location: ../../index.php");
    exit();
}

include "../../config.php";

$id_user = $_SESSION['id'];

// Ambil data siswa + kelas
$q = mysqli_query($conn,
"SELECT siswa.id AS id_siswa, siswa.nama_lengkap, kelas.nama_kelas
 FROM siswa
 JOIN kelas ON kelas.id = siswa.id_kelas
 JOIN users ON users.id_siswa = siswa.id
 WHERE users.id='$id_user'");

$siswa = mysqli_fetch_assoc($q);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Absensi Siswa</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>

<h2>Rekap Absensi</h2>
<p>Nama: <b><?= $siswa['nama_lengkap']; ?></b></p>
<p>Kelas: <b><?= $siswa['nama_kelas']; ?></b></p>

<div class="card">

<h3>Riwayat Absensi</h3>

<table class="tabel">
    <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Status</th>
        <th>Keterangan</th>
    </tr>

<?php
$no = 1;

$q_absen = mysqli_query($conn,
"SELECT * FROM absensi
 WHERE id_user = '$id_user'
   AND jenis_absen = 'siswa'
 ORDER BY tanggal DESC");

while($d = mysqli_fetch_assoc($q_absen)){
?>
<tr>
    <td><?= $no++; ?></td>
    <td><?= $d['tanggal']; ?></td>
    <td><?= $d['status']; ?></td>
    <td><?= $d['keterangan'] ? $d['keterangan'] : "-"; ?></td>
</tr>
<?php } ?>

</table>
</div>

<br>

<!-- REKAP TOTAL -->
<div class="card">

<h3>Ringkasan Kehadiran</h3>

<?php
// Hitung total absensi
$hitung = mysqli_query($conn,
"SELECT status, COUNT(*) AS total
 FROM absensi
 WHERE id_user='$id_user' AND jenis_absen='siswa'
 GROUP BY status");

$rekap = ["Hadir"=>0, "Sakit"=>0, "Izin"=>0, "Alpa"=>0];

while($r = mysqli_fetch_assoc($hitung)){
    $rekap[$r['status']] = $r['total'];
}
?>

<table class="tabel">
    <tr>
        <th>Status</th>
        <th>Jumlah</th>
    </tr>
    <tr><td>Hadir</td><td><?= $rekap["Hadir"]; ?></td></tr>
    <tr><td>Sakit</td><td><?= $rekap["Sakit"]; ?></td></tr>
    <tr><td>Izin</td><td><?= $rekap["Izin"]; ?></td></tr>
    <tr><td>Alpa</td><td><?= $rekap["Alpa"]; ?></td></tr>
</table>

</div>

</div>
</body>
</html>
