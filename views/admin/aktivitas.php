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
    <title>Log Aktivitas</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>

<div class="card">
    <h2>Log Aktivitas User</h2>

    <table class="tabel">
        <tr>
            <th>Waktu</th>
            <th>Username</th>
            <th>Role</th>
            <th>Aktivitas</th>
        </tr>
        <?php
        $logs = mysqli_query($conn,
        "SELECT log_aktivitas.*, users.username
         FROM log_aktivitas
         LEFT JOIN users ON users.id = log_aktivitas.id_user
         ORDER BY log_aktivitas.id DESC");

        while($l = mysqli_fetch_assoc($logs)){
        ?>
        <tr>
            <td><?= $l['waktu']; ?></td>
            <td><?= $l['username']; ?></td>
            <td><?= ucfirst($l['role']); ?></td>
            <td><?= $l['aktivitas']; ?></td>
        </tr>
        <?php } ?>
    </table>
</div>

</div>
</body>
</html>
