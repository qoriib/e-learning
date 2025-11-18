<?php
session_start();
if($_SESSION['role'] != 'siswa'){
    header("Location: ../../index.php");
    exit();
}

include "../../config.php";

$id_user = $_SESSION['id'];

$q = mysqli_query($conn,
"SELECT siswa.*, users.username
 FROM siswa
 JOIN users ON users.id_siswa = siswa.id
 WHERE users.id='$id_user'");

$siswa = mysqli_fetch_assoc($q);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Biodata</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>

<h2>Edit Biodata</h2>

<div class="card">
<form method="POST" action="profil_update.php">

    <input type="hidden" name="id_siswa" value="<?= $siswa['id']; ?>">

    <label>Nama Lengkap</label>
    <input type="text" name="nama" value="<?= $siswa['nama_lengkap']; ?>" required>

    <label>Email</label>
    <input type="email" name="email" value="<?= $siswa['email']; ?>">

    <label>No Telepon</label>
    <input type="text" name="telp" value="<?= $siswa['no_telp']; ?>">

    <button class="btn">Simpan</button>

</form>
</div>

</div>
</body>
</html>
