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
    <title>Upload Materi</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>

<?php if(isset($_GET['error'])): 
    $msg = $_GET['error'] == 'roster' ? "Kelas atau mapel tidak valid untuk jadwal Anda." : "File materi wajib diunggah.";
?>
<div class="alert error"><?= $msg; ?></div>
<?php endif; ?>

<h2>Upload Materi</h2>

<div class="card">

<form action="materi_add_process.php" method="POST" enctype="multipart/form-data">

    <label>Mata Pelajaran</label>
    <select name="mapel" required>
        <option value="">-- Pilih Mapel --</option>
        <?php
        $mapel = mysqli_query($conn,
        "SELECT DISTINCT mapel.id, mapel.nama_mapel
         FROM roster
         JOIN mapel ON roster.id_mapel = mapel.id
         WHERE roster.id_guru = '$id_guru'
         ORDER BY mapel.nama_mapel ASC");
        while($m = mysqli_fetch_assoc($mapel)){
            echo "<option value='".$m['id']."'>".$m['nama_mapel']."</option>";
        }
        ?>
    </select>

    <label>Kelas Tujuan</label>
    <select name="kelas" required>
        <option value="">-- Pilih Kelas --</option>
        <?php
        $kelas = mysqli_query($conn,
        "SELECT DISTINCT kelas.id, kelas.nama_kelas
         FROM roster
         JOIN kelas ON roster.id_kelas = kelas.id
         WHERE roster.id_guru = '$id_guru'
         ORDER BY kelas.nama_kelas ASC");
        while($k = mysqli_fetch_assoc($kelas)){
            echo "<option value='".$k['id']."'>".$k['nama_kelas']."</option>";
        }
        ?>
    </select>

    <label>Judul Materi</label>
    <input type="text" name="judul" required>

    <label>Deskripsi</label>
    <textarea name="deskripsi"></textarea>

    <label>File Materi</label>
    <input type="file" name="file" required>

    <button class="btn">Upload</button>

</form>

</div>

</div>
</body>
</html>
