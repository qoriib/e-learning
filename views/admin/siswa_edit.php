<?php
session_start();
if($_SESSION['role'] != 'admin'){
    header("../../index.php");
    exit();
}

include "../../config.php";

$id = $_GET['id'];
$d = mysqli_fetch_assoc(mysqli_query($conn, 
    "SELECT siswa.*, users.username 
     FROM siswa 
     LEFT JOIN users ON users.id_siswa = siswa.id 
     WHERE siswa.id='$id'"
));
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Siswa</title>
<link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>

<div class="card">
    <h2>Edit Siswa</h2>

    <form action="siswa_edit_process.php" method="POST">

        <input type="hidden" name="id" value="<?= $d['id']; ?>">

        <label>NIS</label>
        <input type="text" name="nis" value="<?= $d['nis']; ?>" required>

        <label>Nama Lengkap</label>
        <input type="text" name="nama" value="<?= $d['nama_lengkap']; ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= $d['email']; ?>">

        <label>No Telp</label>
        <input type="text" name="telp" value="<?= $d['no_telp']; ?>">

        <label>Username</label>
        <input type="text" name="username" value="<?= $d['username']; ?>" required>

        <label>Kelas</label>
        <select name="kelas">
            <?php
            $kelas = mysqli_query($conn, "SELECT * FROM kelas ORDER BY nama_kelas ASC");
            while($k = mysqli_fetch_assoc($kelas)){
                $selected = ($k['id'] == $d['id_kelas']) ? "selected" : "";
                echo "<option value='".$k['id']."' $selected>".$k['nama_kelas']."</option>";
            }
            ?>
        </select>

        <button type="submit" class="btn">Update</button>
    </form>

</div>

</div>
</body>
</html>
