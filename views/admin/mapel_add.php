<?php
session_start();
if($_SESSION['role'] != 'admin'){
    header("Location: ../../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Tambah Mapel</title>
<link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="content">
<?php include "header.php"; ?>

<div class="card">
    <h2>Tambah Mata Pelajaran</h2>

    <form action="mapel_add_process.php" method="POST">

        <label>Nama Mata Pelajaran</label>
        <input type="text" name="nama" required>

        <button type="submit" class="btn">Simpan</button>

    </form>

</div>

</div>

</body>
</html>
