<?php
session_start();
if($_SESSION['role'] != 'admin'){
    header("Location: ../../index.php");
    exit();
}

include "../../config.php";

$id = $_GET['id'];
$d = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM mapel WHERE id='$id'"));
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Mapel</title>
<link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="content">
<?php include "header.php"; ?>

<div class="card">
    <h2>Edit Mata Pelajaran</h2>

    <form action="mapel_edit_process.php" method="POST">

        <input type="hidden" name="id" value="<?= $d['id']; ?>">

        <label>Nama Mata Pelajaran</label>
        <input type="text" name="nama" value="<?= $d['nama_mapel']; ?>" required>

        <button type="submit" class="btn">Update</button>

    </form>

</div>

</div>

</body>
</html>
