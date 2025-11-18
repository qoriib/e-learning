<?php
session_start();
if($_SESSION['role'] != 'guru'){
    header("Location: ../../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Upload Laporan Guru</title>
<link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>
<h2>Upload Laporan</h2>

<div class="card">

<form action="laporan_add_process.php" method="POST" enctype="multipart/form-data">

    <label>Judul Laporan</label>
    <input type="text" name="judul" required>

    <label>File Laporan (PDF/Word/Gambar)</label>
    <input type="file" name="file" required>

    <button type="submit" class="btn">Upload</button>

</form>

</div>
</div>

</body>
</html>
