<?php
session_start();
if($_SESSION['role'] != 'guru'){ header("Location: ../../index.php"); exit(); }

include "../../config.php";
$id_guru = $_SESSION['id'];
$tanggal = date("Y-m-d");

// cek apakah sudah absen
$cek = mysqli_query($conn, 
    "SELECT * FROM absensi 
     WHERE id_user='$id_guru' AND tanggal='$tanggal' AND jenis_absen='guru'"
);
$sudah = mysqli_num_rows($cek) > 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Absensi Guru</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>

<h2>Absensi Guru</h2>

<div class="card">
<?php if($sudah){ ?>

<p style="color:green;">Anda sudah absen hari ini</p>

<?php } else { ?>

<form action="absen_guru_process.php" method="POST">
    <label>Status</label>
    <select name="status">
        <option>Hadir</option>
        <option>Sakit</option>
        <option>Izin</option>
    </select>

    <label>Keterangan</label>
    <textarea name="keterangan"></textarea>

    <button class="btn">Simpan</button>
</form>

<?php } ?>
</div>
</div>
</body>
</html>
</div>
