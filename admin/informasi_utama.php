<?php
include './src/koneksi.php';

if (!isset($_SESSION['username']) || !isset($_SESSION['level'])) {
    header("Location: ../index.php?pesan=belum_login");
    exit;
}

// Hitung jumlah data
$siswa_count = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM siswa"))['total'];
$kelas_count = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM kelas"))['total'];
$spp_count = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM spp"))['total'];
$pembayaran_count = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pembayaran"))['total'];
$petugas_count = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM petugas"))['total'];
?>

<div class="container mx-auto">
    <h2 class="text-xl sm:text-2xl font-bold mb-4">Selamat Datang di Dashboard SPP Online</h2>
    <p class="text-gray-600 mb-6">Sistem Pembayaran SPP SMKN 3 Banjarbaru</p>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold">Jumlah Siswa</h3>
            <p class="text-2xl"><?php echo $siswa_count; ?></p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold">Jumlah Kelas</h3>
            <p class="text-2xl"><?php echo $kelas_count; ?></p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold">Jumlah SPP</h3>
            <p class="text-2xl"><?php echo $spp_count; ?></p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold">Jumlah Pembayaran</h3>
            <p class="text-2xl"><?php echo $pembayaran_count; ?></p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold">Jumlah Petugas</h3>
            <p class="text-2xl"><?php echo $petugas_count; ?></p>
        </div>
    </div>
</div>