<?php
session_start();
if($_SESSION['role'] != 'admin'){
    header("Location: ../../index.php");
    exit();
}
include "../../config.php";

$id = $_GET['id'];
$d = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM kelas WHERE id='$id'"));
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Kelas</title>
<link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="content">
<?php include "header.php"; ?>

<div class="card">
    <h2>Edit Kelas</h2>

    <form action="kelas_edit_process.php" method="POST">

        <input type="hidden" name="id" value="<?= $d['id']; ?>">

        <label>Nama Kelas</label>
        <input type="text" name="nama" value="<?= $d['nama_kelas']; ?>" required>

        <label>Tahun Ajaran</label>
        <select name="tahun" required>
            <?php
            $th = mysqli_query($conn, "SELECT * FROM tahun_ajaran ORDER BY id DESC");
            while($t = mysqli_fetch_assoc($th)){
                $sel = ($t['id'] == $d['id_tahun_ajaran']) ? "selected" : "";
                echo "<option value='".$t['id']."' $sel>".$t['tahun']." (".$t['semester'].")</option>";
            }
            ?>
        </select>

        <button type="submit" class="btn">Update</button>

    </form>

</div>

</div>
</body>
</html>
