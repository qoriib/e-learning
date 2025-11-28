<?php
session_start();
if($_SESSION['role'] != 'admin'){
    header("../../index.php");
    exit();
}

include "../../config.php";

$id = $_GET['id'];
$d = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT guru.*, users.username 
     FROM guru 
     LEFT JOIN users ON users.id_guru = guru.id
     WHERE guru.id='$id'"));
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Guru</title>
<link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>

<div class="card">
    <h2>Edit Guru</h2>

    <form action="guru_edit_process.php" method="POST">

        <input type="hidden" name="id" value="<?= $d['id']; ?>">

        <label>NIP</label>
        <input type="text" name="nip" value="<?= $d['nip']; ?>" required>

        <label>Nama Lengkap</label>
        <input type="text" name="nama" value="<?= $d['nama_lengkap']; ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= $d['email']; ?>">

        <label>No Telp</label>
        <input type="text" name="telp" value="<?= $d['no_telp']; ?>">

        <label>Username</label>
        <input type="text" name="username" value="<?= $d['username']; ?>" required>

        <button type="submit" class="btn">Update</button>

    </form>

</div>

</div>
</body>
</html>
