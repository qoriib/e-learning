<?php
session_start();
if($_SESSION['role'] != 'admin'){
    header("Location: ../../index.php");
    exit();
}

include "../../config.php";
include "../../helpers/pagination_helper.php";
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
    <?php
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $baseQuery = "SELECT log_aktivitas.*, users.username
         FROM log_aktivitas
         LEFT JOIN users ON users.id = log_aktivitas.id_user
         ORDER BY log_aktivitas.id DESC";
    $pagination = paginate_query($conn, $baseQuery, $page, 30);
    $logs = $pagination['result'];
    ?>
    <table class="tabel">
        <tr>
            <th>Waktu</th>
            <th>Username</th>
            <th>Role</th>
            <th>Aktivitas</th>
        </tr>
        <?php
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
    <?= render_pagination('aktivitas.php', $pagination); ?>
</div>

</div>
</body>
</html>
