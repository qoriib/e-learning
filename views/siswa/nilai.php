<?php
session_start();
if($_SESSION['role'] != 'siswa'){
    header("Location: ../../index.php");
    exit();
}

include "../../config.php";
include "../../helpers/auth_helper.php";

$id_user = $_SESSION['id'];
$id_siswa_session = getSiswaId($conn);
if(!$id_siswa_session){
    header("Location: ../../index.php");
    exit();
}

// ambil data siswa + kelas
$sq = mysqli_query($conn,
"SELECT siswa.id AS id_siswa, siswa.nama_lengkap, siswa.id_kelas, kelas.nama_kelas
 FROM siswa
 JOIN kelas ON kelas.id = siswa.id_kelas
 JOIN users ON users.id_siswa = siswa.id
 WHERE users.id='$id_user'");

$siswa = mysqli_fetch_assoc($sq);
$id_siswa = $siswa['id_siswa'];
$id_kelas = $siswa['id_kelas'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nilai Tugas</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>

<h2>Nilai Tugas</h2>
<p>Kelas: <b><?= $siswa['nama_kelas']; ?></b></p>

<div class="card">

<table class="tabel">
    <tr>
        <th>No</th>
        <th>Mapel</th>
        <th>Judul Tugas</th>
        <th>Nilai</th>
        <th>Catatan Guru</th>
        <th>File Kamu</th>
        <th>Status</th>
    </tr>

<?php
$no = 1;

$q = mysqli_query($conn,
"SELECT 
    tugas.judul_tugas,
    tugas.id_mapel,
    mapel.nama_mapel,
    pengumpulan_tugas.nilai,
    pengumpulan_tugas.catatan_nilai,
    pengumpulan_tugas.file_path,
    pengumpulan_tugas.tanggal_kumpul
 FROM pengumpulan_tugas
 JOIN tugas ON tugas.id = pengumpulan_tugas.id_tugas
 JOIN mapel ON mapel.id = tugas.id_mapel
 WHERE pengumpulan_tugas.id_siswa = '$id_siswa'
 ORDER BY pengumpulan_tugas.tanggal_kumpul DESC"
);

while($d = mysqli_fetch_assoc($q)){
?>
<tr>
    <td><?= $no++; ?></td>
    <td><?= $d['nama_mapel']; ?></td>
    <td><?= $d['judul_tugas']; ?></td>
    <td><?= $d['nilai'] !== null ? $d['nilai'] : "-"; ?></td>
    <td><?= $d['catatan_nilai'] ? $d['catatan_nilai'] : "-"; ?></td>

    <td>
        <?php if($d['file_path']) { ?>
            <a href="<?= $d['file_path']; ?>" target="_blank">Lihat File</a>
        <?php } else { echo "-"; } ?>
    </td>

    <td>
        <?php if($d['nilai'] !== null): ?>
            ✔ Sudah Dinilai
        <?php else: ?>
            ⏳ Belum Dinilai
        <?php endif ?>
    </td>

</tr>
<?php } ?>

</table>

</div>

</div>

</body>
</html>
