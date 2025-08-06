<?php
session_start();
include './src/koneksi.php';

if (!isset($_SESSION['username']) || !isset($_SESSION['level'])) {
    header("Location: ../index.php?pesan=belum_login");
    exit;
}

// Create atau Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pembayaran = mysqli_real_escape_string($koneksi, $_POST['id_pembayaran']);
    $id_petugas = mysqli_real_escape_string($koneksi, $_POST['id_petugas']);
    $nisn = mysqli_real_escape_string($koneksi, $_POST['nisn']);
    $tgl_bayar = mysqli_real_escape_string($koneksi, $_POST['tgl_bayar']);
    $bulan_dibayar = mysqli_real_escape_string($koneksi, $_POST['bulan_dibayar']);
    $tahun_dibayar = mysqli_real_escape_string($koneksi, $_POST['tahun_dibayar']);
    $id_spp = mysqli_real_escape_string($koneksi, $_POST['id_spp']);
    $jumlah_bayar = mysqli_real_escape_string($koneksi, $_POST['jumlah_bayar']);
    
    // Cek apakah ini operasi edit atau create
    if (isset($_POST['edit']) && !empty($_POST['edit'])) {
        // Update
        $query = "UPDATE pembayaran SET id_petugas='$id_petugas', nisn='$nisn', tgl_bayar='$tgl_bayar', bulan_dibayar='$bulan_dibayar', tahun_dibayar='$tahun_dibayar', id_spp='$id_spp', jumlah_bayar='$jumlah_bayar' WHERE id_pembayaran='$id_pembayaran'";
    } else {
        // Create: Validasi apakah id_pembayaran sudah ada
        $check_id_pembayaran = mysqli_query($koneksi, "SELECT id_pembayaran FROM pembayaran WHERE id_pembayaran='$id_pembayaran'");
        if (mysqli_num_rows($check_id_pembayaran) > 0) {
            echo "<script>alert('ID Pembayaran sudah ada, silakan masukkan ID Pembayaran lain'); window.location='?open=data_pembayaran';</script>";
            exit;
        }
        // Insert
        $query = "INSERT INTO pembayaran (id_pembayaran, id_petugas, nisn, tgl_bayar, bulan_dibayar, tahun_dibayar, id_spp, jumlah_bayar) VALUES ('$id_pembayaran', '$id_petugas', '$nisn', '$tgl_bayar', '$bulan_dibayar', '$tahun_dibayar', '$id_spp', '$jumlah_bayar')";
    }
    
    mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));
    echo "<script>alert('Data Pembayaran berhasil disimpan'); window.location='?open=data_pembayaran';</script>";
}

// Delete
if (isset($_GET['delete'])) {
    $id_pembayaran = mysqli_real_escape_string($koneksi, $_GET['delete']);
    mysqli_query($koneksi, "DELETE FROM pembayaran WHERE id_pembayaran='$id_pembayaran'") or die(mysqli_error($koneksi));
    echo "<script>alert('Data Pembayaran berhasil dihapus'); window.location='?open=data_pembayaran';</script>";
}

// Edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $id_pembayaran = mysqli_real_escape_string($koneksi, $_GET['edit']);
    $edit_data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pembayaran WHERE id_pembayaran='$id_pembayaran'"));
}

// Read
$result = mysqli_query($koneksi, "SELECT pembayaran.*, petugas.nama_petugas, siswa.nama, spp.tahun FROM pembayaran JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas JOIN siswa ON pembayaran.nisn=siswa.nisn JOIN spp ON pembayaran.id_spp=spp.id_spp") or die(mysqli_error($koneksi));
$petugas_result = mysqli_query($koneksi, "SELECT * FROM petugas");
$siswa_result = mysqli_query($koneksi, "SELECT * FROM siswa");
$spp_result = mysqli_query($koneksi, "SELECT * FROM spp");
?>

<div class="container mx-auto">
    <h2 class="text-xl sm:text-2xl font-bold mb-4">Data Pembayaran</h2>
    
    <!-- Form Create/Update -->
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow mb-6">
        <h3 class="text-lg font-semibold mb-4"><?php echo $edit_data ? 'Edit' : 'Tambah'; ?> Pembayaran</h3>
        <form action="" method="post" class="space-y-4">
            <input type="hidden" name="edit" value="<?php echo $edit_data ? $edit_data['id_pembayaran'] : ''; ?>">
            <div>
                <label class="block text-sm font-medium text-gray-700">ID Pembayaran</label>
                <input type="text" name="id_pembayaran" value="<?php echo $edit_data ? $edit_data['id_pembayaran'] : ''; ?>" required class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" <?php echo $edit_data ? 'readonly' : ''; ?>>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Petugas</label>
                <select name="id_petugas" required class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Petugas</option>
                    <?php while ($petugas = mysqli_fetch_assoc($petugas_result)) { ?>
                        <option value="<?php echo $petugas['id_petugas']; ?>" <?php echo $edit_data && $edit_data['id_petugas'] == $petugas['id_petugas'] ? 'selected' : ''; ?>>
                            <?php echo $petugas['nama_petugas']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Siswa</label>
                <select name="nisn" required class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Siswa</option>
                    <?php while ($siswa = mysqli_fetch_assoc($siswa_result)) { ?>
                        <option value="<?php echo $siswa['nisn']; ?>" <?php echo $edit_data && $edit_data['nisn'] == $siswa['nisn'] ? 'selected' : ''; ?>>
                            <?php echo $siswa['nama']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Bayar</label>
                <input type="date" name="tgl_bayar" value="<?php echo $edit_data ? $edit_data['tgl_bayar'] : ''; ?>" required class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Bulan Dibayar</label>
                <input type="text" name="bulan_dibayar" value="<?php echo $edit_data ? $edit_data['bulan_dibayar'] : ''; ?>" required class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Tahun Dibayar</label>
                <input type="number" name="tahun_dibayar" value="<?php echo $edit_data ? $edit_data['tahun_dibayar'] : ''; ?>" required class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">SPP</label>
                <select name="id_spp" required class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih SPP</option>
                    <?php while ($spp = mysqli_fetch_assoc($spp_result)) { ?>
                        <option value="<?php echo $spp['id_spp']; ?>" <?php echo $edit_data && $edit_data['id_spp'] == $spp['id_spp'] ? 'selected' : ''; ?>>
                            <?php echo $spp['tahun'] . ' - Rp ' . number_format($spp['nominal'], 0, ',', '.'); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Jumlah Bayar</label>
                <input type="number" name="jumlah_bayar" value="<?php echo $edit_data ? $edit_data['jumlah_bayar'] : ''; ?>" required class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700">Simpan</button>
            <?php if ($edit_data) { ?>
                <a href="?open=data_pembayaran" class="bg-gray-600 text-white p-2 rounded-lg hover:bg-gray-700">Batal</a>
            <?php } ?>
        </form>
    </div>

    <!-- Tabel Read -->
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Daftar Pembayaran</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID Pembayaran</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Petugas</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Siswa</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Bulan</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tahun</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">SPP</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td class="px-4 py-2"><?php echo $row['id_pembayaran']; ?></td>
                            <td class="px-4 py-2"><?php echo $row['nama_petugas']; ?></td>
                            <td class="px-4 py-2"><?php echo $row['nama']; ?></td>
                            <td class="px-4 py-2"><?php echo $row['tgl_bayar']; ?></td>
                            <td class="px-4 py-2"><?php echo $row['bulan_dibayar']; ?></td>
                            <td class="px-4 py-2"><?php echo $row['tahun_dibayar']; ?></td>
                            <td class="px-4 py-2"><?php echo $row['tahun']; ?></td>
                            <td class="px-4 py-2"><?php echo number_format($row['jumlah_bayar'], 0, ',', '.'); ?></td>
                            <td class="px-4 py-2">
                                <a href="?open=data_pembayaran&edit=<?php echo $row['id_pembayaran']; ?>" class="text-blue-600 hover:underline">Edit</a>
                                <a href="?open=data_pembayaran&delete=<?php echo $row['id_pembayaran']; ?>" class="text-red-600 hover:underline ml-2" onclick="return confirm('Yakin hapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>