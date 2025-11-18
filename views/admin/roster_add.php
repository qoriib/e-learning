<?php
session_start();
if($_SESSION['role'] != 'admin'){
    header("Location: ../../index.php");
    exit();
}
include "../../config.php";
?>

<!DOCTYPE html>
<html>
<head>
<title>Tambah Roster</title>
<link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="content">
<?php include "header.php"; ?>

<div class="card">
    <h2>Tambah Jadwal Pelajaran</h2>

    <form action="roster_add_process.php" method="POST">

        <label>Kelas</label>
        <select name="kelas" required>
            <option value="">-- Pilih Kelas --</option>
            <?php
            $kelas = mysqli_query($conn, "SELECT * FROM kelas ORDER BY nama_kelas ASC");
            while($k = mysqli_fetch_assoc($kelas)){
                echo "<option value='".$k['id']."'>".$k['nama_kelas']."</option>";
            }
            ?>
        </select>

        <label>Mata Pelajaran</label>
        <select name="mapel" required>
            <option value="">-- Pilih Mapel --</option>
            <?php
            $mapel = mysqli_query($conn, "SELECT * FROM mapel ORDER BY nama_mapel ASC");
            while($m = mysqli_fetch_assoc($mapel)){
                echo "<option value='".$m['id']."'>".$m['nama_mapel']."</option>";
            }
            ?>
        </select>

        <label>Guru Pengajar</label>
        <select name="guru" required>
            <option value="">-- Pilih Guru --</option>
            <?php
            $guru = mysqli_query($conn, "SELECT * FROM guru ORDER BY nama_lengkap ASC");
            while($g = mysqli_fetch_assoc($guru)){
                echo "<option value='".$g['id']."'>".$g['nama_lengkap']."</option>";
            }
            ?>
        </select>

        <label>Hari</label>
        <select name="hari" required>
            <option value="">-- Pilih Hari --</option>
            <option>Senin</option>
            <option>Selasa</option>
            <option>Rabu</option>
            <option>Kamis</option>
            <option>Jumat</option>
            <option>Sabtu</option>
        </select>

        <label>Jam Mulai</label>
        <input type="time" name="jam_mulai" required>

        <label>Jam Selesai</label>
        <input type="time" name="jam_selesai" required>

        <button type="submit" class="btn">Simpan</button>
    </form>

</div>

</div>

</body>
</html>
