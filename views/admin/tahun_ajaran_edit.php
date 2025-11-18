<?php
session_start();
if($_SESSION['role'] != 'admin'){
    header("Location: ../../index.php");
    exit();
}

include "../../config.php";

$id = $_GET['id'];
$d = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tahun_ajaran WHERE id='$id'"));
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Tahun Ajaran</title>
<link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">

<?php include "header.php"; ?>

<div class="card">
    <h2>Edit Tahun Ajaran</h2>

    <form action="tahun_ajaran_edit_process.php" method="POST">

        <input type="hidden" name="id" value="<?= $d['id']; ?>">

        <label>Tahun</label>
        <input type="text" name="tahun" value="<?= $d['tahun']; ?>" required>

        <label>Semester</label>
        <select name="semester">
            <option <?= $d['semester']=='Ganjil'?'selected':''; ?>>Ganjil</option>
            <option <?= $d['semester']=='Genap'?'selected':''; ?>>Genap</option>
        </select>

        <button type="submit" class="btn">Update</button>

    </form>

</div>

</div>
</body>
</html>
