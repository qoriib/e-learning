<?php
session_start();
if($_SESSION['role'] != 'guru'){
    header("Location: ../../index.php");
    exit();
}

include "../../config.php";
include "../../helpers/auth_helper.php";
include "../../helpers/pagination_helper.php";
include "../../helpers/file_helper.php";

$id_guru = getGuruId($conn);
if(!$id_guru){
    header("Location: ../../index.php");
    exit();
}

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

<?php
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$baseQuery = "SELECT materi.*, mapel.nama_mapel, kelas.nama_kelas
 FROM materi
 JOIN mapel ON materi.id_mapel = mapel.id
 LEFT JOIN materi_kelas ON materi_kelas.id_materi = materi.id
 LEFT JOIN kelas ON kelas.id = materi_kelas.id_kelas
 WHERE materi.id_guru = '$id_guru'
 ORDER BY materi.id DESC";
$pagination = paginate_query($conn, $baseQuery, $page, 30);
$q = $pagination['result'];
?>

<table class="tabel">
    <tr>
        <th>No</th>
        <th>Mapel</th>
        <th>Kelas</th>
        <th>Judul</th>
        <th>File</th>
        <th>Tanggal Upload</th>
        <th>Aksi</th>
    </tr>

<?php
$no = $pagination['offset'] + 1;
while($d = mysqli_fetch_assoc($q)){
?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= $d['nama_mapel']; ?></td>
        <td><?= $d['nama_kelas'] ? $d['nama_kelas'] : '-'; ?></td>
        <td><?= $d['judul_materi']; ?></td>
        <td><a href="<?= view_file_href($d['file_path']); ?>" target="_blank">Download</a></td>
        <td><?= $d['tanggal_upload']; ?></td>
        <td>
            <a href="materi_delete.php?id=<?= $d['id']; ?>"
               onclick="return confirm('Hapus materi ini?')">Hapus</a>
        </td>
    </tr>

<?php } ?>
</table>
<?= render_pagination('materi.php', $pagination); ?>

</div>

</div>
</body>
</html>
