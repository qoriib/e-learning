<?php
session_start();
if($_SESSION['role'] != 'admin'){
    header("Location: ../../index.php");
    exit();
}
include "../../config.php";
include "../../helpers/file_helper.php";
include "../../helpers/pagination_helper.php";
include "../../helpers/file_helper.php";
?>

<!DOCTYPE html>
<html>
<head>
<title>Laporan Guru</title>
<link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>

<div class="card">
<h2>Daftar Laporan Guru</h2>
<?php
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$baseQuery = "SELECT laporan.*, guru.nama_lengkap 
 FROM laporan
 JOIN guru ON laporan.id_guru = guru.id
 ORDER BY laporan.id DESC";
$pagination = paginate_query($conn, $baseQuery, $page, 30);
$data = $pagination['result'];
?>

<table class="tabel">
    <tr>
        <th>No</th>
        <th>Guru</th>
        <th>Judul</th>
        <th>File</th>
        <th>Status</th>
        <th>Tanggal Upload</th>
        <th>Aksi</th>
    </tr>

<?php
$no = $pagination['offset'] + 1;
while($d = mysqli_fetch_assoc($data)){
?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= $d['nama_lengkap']; ?></td>
        <td><?= $d['judul_laporan']; ?></td>
        <td><a href="<?= view_file_href($d['file_path']); ?>" target="_blank">Download</a></td>
        <td><?= $d['status']; ?></td>
        <td><?= $d['tanggal_upload']; ?></td>
        <td>
            <?php if($d['status']=="belum dibaca"){ ?>
                <a href="laporan_view.php?id=<?= $d['id']; ?>">Tandai Dibaca</a> |
            <?php } ?>
            <a href="laporan_delete.php?id=<?= $d['id']; ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
        </td>
    </tr>
<?php } ?>

</table>
<?= render_pagination('laporan.php', $pagination); ?>

</div>
</div>
</body>
</html>
