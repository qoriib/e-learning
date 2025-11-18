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
<title>Tambah Tahun Ajaran</title>
<link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="content">
<?php include "header.php"; ?>

<div class="card">
    <h2>Tambah Tahun Ajaran</h2>

    <form action="tahun_ajaran_add_process.php" method="POST">

        <label>Tahun (contoh: 2024/2025)</label>
        <input type="text" name="tahun" required>

        <label>Semester</label>
        <select name="semester" required>
            <option value="">-- Pilih Semester --</option>
            <option>Ganjil</option>
            <option>Genap</option>
        </select>

        <button type="submit" class="btn">Simpan</button>

    </form>
</div>

</div>
</body>
</html>
