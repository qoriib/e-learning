<?php
session_start();
if($_SESSION['role'] != 'guru'){
    header("Location: ../../index.php");
    exit();
}

include "../../config.php";

$id_guru = $_SESSION['id'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Materi Guru</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>

<h2>Materi Saya</h2>

<div class="card">

<a href="materi_add.php" class="btn">+ Upload Materi</a>
<br><br>

<table class="tabel">
    <tr>
        <th>No</th>
        <th>Mapel</th>
        <th>Judul</th>
        <th>File</th>
        <th>Tanggal Upload</th>
        <th>Aksi</th>
    </tr>

<?php
$no = 1;

$q = mysqli_query($conn, 
"SELECT materi.*, mapel.nama_mapel 
 FROM materi
 JOIN mapel ON materi.id_mapel = mapel.id
 WHERE materi.id_guru = '$id_guru'
 ORDER BY materi.id DESC");

while($d = mysqli_fetch_assoc($q)){
?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= $d['nama_mapel']; ?></td>
        <td><?= $d['judul_materi']; ?></td>
        <td><a href="<?= $d['file_path']; ?>" target="_blank">Download</a></td>
        <td><?= $d['tanggal_upload']; ?></td>
        <td>
            <a href="materi_delete.php?id=<?= $d['id']; ?>"
               onclick="return confirm('Hapus materi ini?')">Hapus</a>
        </td>
    </tr>

<?php } ?>
</table>

</div>

</div>
</body>
</html>
