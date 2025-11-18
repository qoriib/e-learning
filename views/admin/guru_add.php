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
<title>Tambah Guru</title>
<link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="content">
<?php include "header.php"; ?>

<div class="card">
    <h2>Tambah Guru</h2>

    <form action="guru_add_process.php" method="POST">

        <label>NIP</label>
        <input type="text" name="nip" required>

        <label>Nama Lengkap</label>
        <input type="text" name="nama" required>

        <label>Email</label>
        <input type="email" name="email">

        <label>No Telp</label>
        <input type="text" name="telp">

        <button type="submit" class="btn">Simpan</button>
    </form>

</div>

</div>
</body>
</html>
