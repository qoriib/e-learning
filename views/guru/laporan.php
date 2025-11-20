<?php
session_start();
if($_SESSION['role'] != 'guru'){
    header("Location: ../../index.php");
    exit();
}

include "../../config.php";
include "../../helpers/auth_helper.php";
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

<table class="tabel">
    <tr>
        <th>No</th>
        <th>Judul</th>
        <th>File</th>
        <th>Status</th>
        <th>Tanggal Upload</th>
    </tr>

<?php
$no = 1;
$data = mysqli_query($conn, "SELECT * FROM laporan WHERE id_guru='$id_guru' ORDER BY id DESC");
while($d = mysqli_fetch_assoc($data)){
?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= $d['judul_laporan']; ?></td>
        <td><a href="<?= $d['file_path']; ?>" target="_blank">Download</a></td>
        <td><?= $d['status']; ?></td>
        <td><?= $d['tanggal_upload']; ?></td>
    </tr>
<?php } ?>

</table>

</div>
</div>

</body>
</html>
