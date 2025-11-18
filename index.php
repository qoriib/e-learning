<?php
session_start();
if(isset($_SESSION['role'])){
    if($_SESSION['role'] == 'admin'){
        header("Location: views/admin/dashboard.php");
    } elseif($_SESSION['role'] == 'guru'){
        header("Location: views/guru/dashboard.php");
    } elseif($_SESSION['role'] == 'siswa'){
        header("Location: views/siswa/dashboard.php");
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login E-Learning</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<div class="login-container">
    <div class="login-box">

        <h2>E-Learning Sekolah</h2>
        <p class="subtitle">Silakan login untuk melanjutkan</p>

        <?php if(isset($_GET['error'])){ ?>
            <div class="error-msg"><?php echo $_GET['error']; ?></div>
        <?php } ?>

        <form action="login_process.php" method="POST">

            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="btn-login">Login</button>
        </form>
    </div>
</div>

</body>
</html>
