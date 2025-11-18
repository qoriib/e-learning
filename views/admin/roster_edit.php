<?php
session_start();
if($_SESSION['role'] != 'admin'){
    header("Location: ../../index.php");
    exit();
}
include "../../config.php";

$id = $_GET['id'];
$d = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT * FROM roster WHERE id='$id'"
));
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Roster</title>
<link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>

<div class="card">
    <h2>Edit Jadwal Pelajaran</h2>

    <form action="roster_edit_process.php" method="POST">

        <input type="hidden" name="id" value="<?= $d['id']; ?>">

        <label>Kelas</label>
        <select name="kelas">
            <?php
            $kelas = mysqli_query($conn, "SELECT * FROM kelas");
            while($k = mysqli_fetch_assoc($kelas)){
                $sel = ($k['id'] == $d['id_kelas']) ? "selected" : "";
                echo "<option value='".$k['id']."' $sel>".$k['nama_kelas']."</option>";
            }
            ?>
        </select>

        <label>Mapel</label>
        <select name="mapel">
            <?php
            $mapel = mysqli_query($conn, "SELECT * FROM mapel");
            while($m = mysqli_fetch_assoc($mapel)){
                $sel = ($m['id'] == $d['id_mapel']) ? "selected" : "";
                echo "<option value='".$m['id']."' $sel>".$m['nama_mapel']."</option>";
            }
            ?>
        </select>

        <label>Guru</label>
        <select name="guru">
            <?php
            $guru = mysqli_query($conn, "SELECT * FROM guru");
            while($g = mysqli_fetch_assoc($guru)){
                $sel = ($g['id'] == $d['id_guru']) ? "selected" : "";
                echo "<option value='".$g['id']."' $sel>".$g['nama_lengkap']."</option>";
            }
            ?>
        </select>

        <label>Hari</label>
        <select name="hari">
            <?php
            $hari_list = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
            foreach($hari_list as $h){
                $sel = ($h == $d['hari']) ? "selected" : "";
                echo "<option $sel>$h</option>";
            }
            ?>
        </select>

        <label>Jam Mulai</label>
        <input type="time" name="jam_mulai" value="<?= $d['jam_mulai']; ?>">

        <label>Jam Selesai</label>
        <input type="time" name="jam_selesai" value="<?= $d['jam_selesai']; ?>">

        <button type="submit" class="btn">Update</button>
    </form>

</div>

</div>
</body>
</html>
