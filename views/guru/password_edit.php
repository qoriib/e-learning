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
    <title>Ganti Password</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>

<h2>Ganti Password</h2>

<div class="card">
<?php if(isset($_GET['error'])): ?>
    <div class="alert error">Konfirmasi password tidak sama.</div>
<?php endif; ?>
<form method="POST" action="password_update.php">

    <label>Password Baru</label>
    <input type="password" name="password1" required>

    <label>Ulangi Password Baru</label>
    <input type="password" name="password2" required>

    <button class="btn">Simpan Password</button>

</form>
</div>

</div>
</body>
</html>
