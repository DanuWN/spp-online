<?php
session_start();
include 'src/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']); // Note: MD5 is insecure, consider using password_hash()

    $login = mysqli_query($koneksi, "SELECT * FROM petugas WHERE username='$username' AND password='$password'")
        or die(mysqli_error($koneksi));
    $cek = mysqli_num_rows($login);

    if ($cek > 0) {
        $data = mysqli_fetch_assoc($login);
        
        $_SESSION['username'] = $username;
        $_SESSION['level'] = $data['level'];
        
        if ($data['level'] == "admin") {
            echo "<script>alert('Anda berhasil login sebagai admin'); window.location='index.php';</script>";
        } elseif ($data['level'] == "petugas") {
            echo "<script>alert('Anda berhasil login sebagai petugas'); window.location='index.php';</script>";
        } else {
            header("location:index.php?pesan=gagal");
        }
    } else {
        header("location:index.php?pesan=gagal");
    }
} else {
    header("location:index.php?pesan=gagal");
}
?>