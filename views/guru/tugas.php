<?php
session_start();
if($_SESSION['role'] != 'guru'){
    header("Location: ../../index.php");
    exit();
}

include "../../config.php";
include "../../helpers/auth_helper.php";
include "../../helpers/file_helper.php";
include "../../helpers/pagination_helper.php";
$id_guru = getGuruId($conn);
if(!$id_guru){
    header("Location: ../../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tugas Guru</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>

<h2>Daftar Tugas</h2>

<div class="card">

<a href="tugas_add.php" class="btn">+ Buat Tugas</a>
<br><br>

<?php
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$baseQuery = "SELECT tugas.*, kelas.nama_kelas, mapel.nama_mapel 
 FROM tugas
 JOIN kelas ON tugas.id_kelas = kelas.id
 JOIN mapel ON tugas.id_mapel = mapel.id
 WHERE tugas.id_guru = '$id_guru'
 ORDER BY tugas.id DESC";
$pagination = paginate_query($conn, $baseQuery, $page, 30);
$q = $pagination['result'];
?>

<table class="tabel">
    <tr>
        <th>No</th>
        <th>Kelas</th>
        <th>Mapel</th>
        <th>Judul</th>
        <th>Deadline</th>
        <th>File</th>
        <th>Aksi</th>
    </tr>

<?php
$no = $pagination['offset'] + 1;

while($d = mysqli_fetch_assoc($q)){
$downloadPath = $d['file_path'] ? view_file_href($d['file_path']) : null;
?>
<tr>
    <td><?= $no++; ?></td>
    <td><?= $d['nama_kelas']; ?></td>
    <td><?= $d['nama_mapel']; ?></td>
    <td><?= $d['judul_tugas']; ?></td>
    <td><?= $d['deadline']; ?></td>
    <td>
        <?php if($downloadPath){ ?>
            <a href="<?= $downloadPath; ?>" target="_blank">Download</a>
        <?php } else { echo "-"; } ?>
    </td>
    <td>
        <a href="tugas_kumpul.php?id=<?= $d['id']; ?>">Lihat Pengumpulan</a> |
        <a href="tugas_delete.php?id=<?= $d['id']; ?>" onclick="return confirm('Hapus tugas ini?')">
            Hapus
        </a>
    </td>
</tr>
<?php } ?>
</table>
<?= render_pagination('tugas.php', $pagination); ?>

</div>

</div>
</body>
</html>
