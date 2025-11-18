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
<title>Tambah Siswa</title>
<link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="content">
<?php include "header.php"; ?>

<div class="card">
    <h2>Tambah Siswa</h2>

    <form action="siswa_add_process.php" method="POST">

        <label>NIS</label>
        <input type="text" name="nis" required>

        <label>Nama Lengkap</label>
        <input type="text" name="nama" required>

        <label>Email</label>
        <input type="email" name="email">

        <label>No Telp</label>
        <input type="text" name="telp">

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

        <button type="submit" class="btn">Simpan</button>
    </form>

</div>

</div>
</body>
</html>
