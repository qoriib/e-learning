<?php
session_start();
if($_SESSION['role'] != 'siswa'){
    header("Location: ../../index.php");
    exit();
}

include "../../config.php";

$id_user = $_SESSION['id'];

// ambil data siswa lengkap
$q = mysqli_query($conn,
"SELECT siswa.*, kelas.nama_kelas, users.username
 FROM siswa
 JOIN kelas ON kelas.id = siswa.id_kelas
 JOIN users ON users.id_siswa = siswa.id
 WHERE users.id='$id_user'");

$siswa = mysqli_fetch_assoc($q);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profil Siswa</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>

<h2>Profil Siswa</h2>

<div class="card">

<h3>Biodata</h3>

<table class="tabel">
    <tr><td><b>Nama</b></td><td><?= $siswa['nama_lengkap']; ?></td></tr>
    <tr><td><b>NIS</b></td><td><?= $siswa['nis']; ?></td></tr>
    <tr><td><b>Kelas</b></td><td><?= $siswa['nama_kelas']; ?></td></tr>
    <tr><td><b>Email</b></td><td><?= $siswa['email']; ?></td></tr>
    <tr><td><b>No. Telepon</b></td><td><?= $siswa['no_telp']; ?></td></tr>
    <tr><td><b>Username</b></td><td><?= $siswa['username']; ?></td></tr>
</table>

<br>

<a class="btn" href="profil_edit.php">Edit Biodata</a>
<a class="btn" href="password_edit.php">Ubah Password</a>

</div>

</div>

</body>
</html>
