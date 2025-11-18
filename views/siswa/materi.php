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
    <title>Materi Pelajaran</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>

<h2>Materi Pelajaran</h2>
<p>Kelas: <b><?= $siswa['nama_kelas']; ?></b></p>

<div class="card">

<table class="tabel">
    <tr>
        <th>No</th>
        <th>Mapel</th>
        <th>Guru</th>
        <th>Judul Materi</th>
        <th>Deskripsi</th>
        <th>File</th>
        <th>Tanggal</th>
    </tr>

<?php
$no = 1;

// Query materi sesuai kelas siswa
$q2 = mysqli_query($conn,
"SELECT materi.*, mapel.nama_mapel, guru.nama_lengkap
 FROM materi
 JOIN mapel ON materi.id_mapel = mapel.id
 JOIN guru ON materi.id_guru = guru.id
 JOIN roster ON roster.id_mapel = materi.id_mapel AND roster.id_guru = materi.id_guru
 WHERE roster.id_kelas = '$id_kelas'
 ORDER BY materi.tanggal_upload DESC");

while($d = mysqli_fetch_assoc($q2)){
?>
<tr>
    <td><?= $no++; ?></td>
    <td><?= $d['nama_mapel']; ?></td>
    <td><?= $d['nama_lengkap']; ?></td>
    <td><?= $d['judul_materi']; ?></td>
    <td><?= $d['deskripsi'] ? $d['deskripsi'] : "-"; ?></td>
    <td>
        <a href="<?= $d['file_path']; ?>" target="_blank">Download</a>
    </td>
    <td><?= $d['tanggal_upload']; ?></td>
</tr>
<?php } ?>

</table>

</div>

</div>

</body>
</html>
