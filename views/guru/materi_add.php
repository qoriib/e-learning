<?php
session_start();
if($_SESSION['role'] != 'guru'){ 
    header("Location: ../../index.php"); 
    exit(); 
}

include "../../config.php";

?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Materi</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>

<h2>Upload Materi</h2>

<div class="card">

<form action="materi_add_process.php" method="POST" enctype="multipart/form-data">

    <label>Mata Pelajaran</label>
    <select name="mapel" required>
        <option value="">-- Pilih Mapel --</option>
        <?php
        $q = mysqli_query($conn, "SELECT * FROM mapel ORDER BY nama_mapel ASC");
        while($m = mysqli_fetch_assoc($q)){
            echo "<option value='".$m['id']."'>".$m['nama_mapel']."</option>";
        }
        ?>
    </select>

    <label>Judul Materi</label>
    <input type="text" name="judul" required>

    <label>Deskripsi</label>
    <textarea name="deskripsi"></textarea>

    <label>File Materi</label>
    <input type="file" name="file" required>

    <button class="btn">Upload</button>

</form>

</div>

</div>
</body>
</html>
