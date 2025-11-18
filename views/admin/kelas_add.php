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
<title>Tambah Kelas</title>
<link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="content">
<?php include "header.php"; ?>

<div class="card">
    <h2>Tambah Kelas</h2>

    <form action="kelas_add_process.php" method="POST">

        <label>Nama Kelas</label>
        <input type="text" name="nama" required>

        <label>Tahun Ajaran</label>
        <select name="tahun" required>
            <option value="">-- Pilih Tahun Ajaran --</option>
            <?php
            $th = mysqli_query($conn, "SELECT * FROM tahun_ajaran WHERE is_active=1 ORDER BY id DESC");
            while($t = mysqli_fetch_assoc($th)){
                echo "<option value='".$t['id']."'>".$t['tahun']." (".$t['semester'].")</option>";
            }
            ?>
        </select>

        <button type="submit" class="btn">Simpan</button>
    </form>

</div>

</div>
</body>
</html>
