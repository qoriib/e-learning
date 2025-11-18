<?php
session_start();
if($_SESSION['role'] != 'siswa'){
    header("Location: ../../index.php");
    exit();
}

include "../../config.php";

$id_user = $_SESSION['id'];

// ambil info siswa
$sq = mysqli_query($conn,
"SELECT siswa.*, kelas.nama_kelas
 FROM siswa
 JOIN kelas ON kelas.id = siswa.id_kelas
 JOIN users ON users.id_siswa = siswa.id
 WHERE users.id='$id_user'");

$siswa = mysqli_fetch_assoc($sq);
$id_kelas = $siswa['id_kelas'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tugas Siswa</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>

<h2>Daftar Tugas</h2>
<p>Kelas: <b><?= $siswa['nama_kelas']; ?></b></p>

<div class="card">

<table class="tabel">
    <tr>
        <th>No</th>
        <th>Mapel</th>
        <th>Judul</th>
        <th>Deskripsi</th>
        <th>Deadline</th>
        <th>File</th>
        <th>Aksi</th>
    </tr>

<?php
$no = 1;

$q = mysqli_query($conn,
"SELECT tugas.*, mapel.nama_mapel, guru.nama_lengkap
 FROM tugas
 JOIN mapel ON tugas.id_mapel = mapel.id
 JOIN guru ON tugas.id_guru = guru.id
 WHERE tugas.id_kelas='$id_kelas'
 ORDER BY tugas.deadline ASC"
);

while($d = mysqli_fetch_assoc($q)){

    // cek apakah siswa sudah mengumpulkan tugas
    $cek = mysqli_query($conn,
    "SELECT id FROM pengumpulan_tugas 
     WHERE id_tugas='".$d['id']."' 
       AND id_siswa='".$siswa['id']."'");

    $sudah = mysqli_num_rows($cek) > 0;
?>
<tr>
    <td><?= $no++; ?></td>
    <td><?= $d['nama_mapel']; ?></td>
    <td><?= $d['judul_tugas']; ?></td>
    <td><?= $d['deskripsi']; ?></td>
    <td><?= $d['deadline']; ?></td>

    <td>
        <?php if($d['file_path']){ ?>
            <a href="<?= $d['file_path']; ?>" target="_blank">Download</a>
        <?php } else { echo "-"; } ?>
    </td>

    <td>
        <?php if($sudah): ?>
            ✔ Sudah Upload
        <?php else: ?>
            <a class="btn-sm" href="tugas_upload.php?id=<?= $d['id']; ?>">Upload</a>
        <?php endif; ?>
    </td>
</tr>
<?php } ?>

</table>

</div>
</div>
</body>
</html>
