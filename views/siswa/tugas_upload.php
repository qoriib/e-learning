<?php
session_start();
if($_SESSION['role'] != 'siswa'){
    header("Location: ../../index.php");
    exit();
}

include "../../config.php";
include "../../helpers/auth_helper.php";

$id_user = $_SESSION['id'];
$id_tugas = $_GET['id'];
$id_siswa = getSiswaId($conn);
if(!$id_siswa){
    header("Location: ../../index.php");
    exit();
}

// ambil info siswa
$sq = mysqli_query($conn,
"SELECT siswa.*, kelas.nama_kelas
 FROM siswa
 JOIN kelas ON kelas.id = siswa.id_kelas
 JOIN users ON users.id_siswa = siswa.id
 WHERE users.id='$id_user'");

$siswa = mysqli_fetch_assoc($sq);

// ambil info tugas
$tugas = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM tugas WHERE id='$id_tugas'"));
if(!$tugas){
    header("Location: tugas.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Tugas</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>

<h2>Upload Tugas</h2>

<div class="card">

<p><b>Judul:</b> <?= $tugas['judul_tugas']; ?></p>
<p><b>Deadline:</b> <?= $tugas['deadline']; ?></p>

<?php
// CEK DEADLINE
if(strtotime(date("Y-m-d H:i:s")) > strtotime($tugas['deadline'])) {
    echo "<p style='color:red;'><b>Deadline sudah lewat, tidak bisa upload!</b></p>";
    exit();
}
?>

<form method="POST" action="tugas_upload_process.php" enctype="multipart/form-data">

    <input type="hidden" name="id_tugas" value="<?= $id_tugas; ?>">
    <input type="hidden" name="id_siswa" value="<?= $siswa['id']; ?>">

    <label>Upload File (PDF/Word/Gambar)</label>
    <input type="file" name="file_tugas" required>

    <button class="btn">Kumpulkan</button>
</form>

</div>
</div>

</body>
</html>
