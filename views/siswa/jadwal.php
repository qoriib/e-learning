<?php
session_start();
if($_SESSION['role'] != 'siswa'){
    header("Location: ../../index.php");
    exit();
}

include "../../config.php";

$id_user = $_SESSION['id'];

// cari id_siswa & kelas
$q = mysqli_query($conn,
"SELECT siswa.id AS id_siswa, siswa.nama_lengkap, siswa.id_kelas, kelas.nama_kelas
 FROM siswa
 JOIN kelas ON kelas.id = siswa.id_kelas
 JOIN users ON users.id_siswa = siswa.id
 WHERE users.id='$id_user'");

$siswa = mysqli_fetch_assoc($q);
$id_kelas = $siswa['id_kelas'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Pelajaran</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>

<h2>Jadwal Pelajaran</h2>
<p>Kelas: <b><?= $siswa['nama_kelas']; ?></b></p>

<div class="card">

<table class="tabel">
    <tr>
        <th>Hari</th>
        <th>Jam</th>
        <th>Mata Pelajaran</th>
        <th>Guru</th>
    </tr>

<?php
// Ambil roster kelas siswa
$q2 = mysqli_query($conn,
"SELECT roster.*, mapel.nama_mapel, guru.nama_lengkap
 FROM roster
 JOIN mapel ON roster.id_mapel = mapel.id
 JOIN guru ON roster.id_guru = guru.id
 WHERE roster.id_kelas = '$id_kelas'
 ORDER BY FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'), jam_mulai ASC");

while($d = mysqli_fetch_assoc($q2)){
?>
<tr>
    <td><?= $d['hari']; ?></td>
    <td><?= substr($d['jam_mulai'],0,5) ?> - <?= substr($d['jam_selesai'],0,5) ?></td>
    <td><?= $d['nama_mapel']; ?></td>
    <td><?= $d['nama_lengkap']; ?></td>
</tr>
<?php } ?>

</table>

</div>

</div>

</body>
</html>
