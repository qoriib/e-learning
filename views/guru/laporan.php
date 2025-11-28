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
<title>Laporan Saya</title>
<link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>
<h2>Laporan Saya</h2>

<div class="card">

<a href="laporan_add.php" class="btn">+ Upload Laporan</a>
<br><br>

<?php
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$baseQuery = "SELECT * FROM laporan WHERE id_guru='$id_guru' ORDER BY id DESC";
$pagination = paginate_query($conn, $baseQuery, $page, 30);
$data = $pagination['result'];
?>

<table class="tabel">
    <tr>
        <th>No</th>
        <th>Judul</th>
        <th>File</th>
        <th>Status</th>
        <th>Tanggal Upload</th>
    </tr>

<?php
$no = $pagination['offset'] + 1;
while($d = mysqli_fetch_assoc($data)){
?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= $d['judul_laporan']; ?></td>
        <td><a href="<?= view_file_href($d['file_path']); ?>" target="_blank">Download</a></td>
        <td><?= $d['status']; ?></td>
        <td><?= $d['tanggal_upload']; ?></td>
    </tr>
<?php } ?>

</table>
<?= render_pagination('laporan.php', $pagination); ?>

</div>
</div>

</body>
</html>
