<?php
$host = "localhost";
$user = "root";
$pass = "mysql";
$db = "elearning_sekolah";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
