<?php
session_start();
include './src/koneksi.php';

if (!isset($_SESSION['username']) || !isset($_SESSION['level'])) {
    header("Location: ../index.php?pesan=belum_login");
    exit;
}

// Create atau Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nisn = mysqli_real_escape_string($koneksi, $_POST['nisn']);
    $nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $id_kelas = mysqli_real_escape_string($koneksi, $_POST['id_kelas']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $no_telp = mysqli_real_escape_string($koneksi, $_POST['no_telp']);
    $id_spp = mysqli_real_escape_string($koneksi, $_POST['id_spp']);
    
    if (isset($_POST['nisn']) && !empty($_POST['nisn'])) {
        // Update
        $query = "UPDATE siswa SET nis='$nis', nama='$nama', id_kelas='$id_kelas', alamat='$alamat', no_telp='$no_telp', id_spp='$id_spp' WHERE nisn='$nisn'";
    } else {
        // Create
        $query = "INSERT INTO siswa (nisn, nis, nama, id_kelas, alamat, no_telp, id_spp) VALUES ('$nisn', '$nis', '$nama', '$id_kelas', '$alamat', '$no_telp', '$id_spp')";
    }
    
    mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));
    echo "<script>alert('Data Siswa berhasil disimpan'); window.location='?open=data_siswa';</script>";
}

// Delete
if (isset($_GET['delete'])) {
    $nisn = mysqli_real_escape_string($koneksi, $_GET['delete']);
    mysqli_query($koneksi, "DELETE FROM siswa WHERE nisn='$nisn'") or die(mysqli_error($koneksi));
    echo "<script>alert('Data Siswa berhasil dihapus'); window.location='?open=data_siswa';</script>";
}

// Edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $nisn = mysqli_real_escape_string($koneksi, $_GET['edit']);
    $edit_data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM siswa WHERE nisn='$nisn'"));
}

// Read
$result = mysqli_query($koneksi, "SELECT siswa.*, kelas.nama_kelas, spp.tahun FROM siswa JOIN kelas ON siswa.id_kelas=kelas.id_kelas JOIN spp ON siswa.id_spp=spp.id_spp") or die(mysqli_error($koneksi));
$kelas_result = mysqli_query($koneksi, "SELECT * FROM kelas");
$spp_result = mysqli_query($koneksi, "SELECT * FROM spp");
?>

<div class="container mx-auto">
    <h2 class="text-xl sm:text-2xl font-bold mb-4">Data Siswa</h2>
    
    <!-- Form Create/Update -->
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow mb-6">
        <h3 class="text-lg font-semibold mb-4"><?php echo $edit_data ? 'Edit' : 'Tambah'; ?> Siswa</h3>
        <form action="" method="post" class="space-y-4">
            <input type="hidden" name="nisn" value="<?php echo $edit_data ? $edit_data['nisn'] : ''; ?>">
            <div>
                <label class="block text-sm font-medium text-gray-700">NISN</label>
                <input type="text" name="nisn" value="<?php echo $edit_data ? $edit_data['nisn'] : ''; ?>" required class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" <?php echo $edit_data ? 'readonly' : ''; ?>>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">NIS</label>
                <input type="text" name="nis" value="<?php echo $edit_data ? $edit_data['nis'] : ''; ?>" required class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" value="<?php echo $edit_data ? $edit_data['nama'] : ''; ?>" required class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Kelas</label>
                <select name="id_kelas" required class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Kelas</option>
                    <?php while ($kelas = mysqli_fetch_assoc($kelas_result)) { ?>
                        <option value="<?php echo $kelas['id_kelas']; ?>" <?php echo $edit_data && $edit_data['id_kelas'] == $kelas['id_kelas'] ? 'selected' : ''; ?>>
                            <?php echo $kelas['nama_kelas']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Alamat</label>
                <input type="text" name="alamat" value="<?php echo $edit_data ? $edit_data['alamat'] : ''; ?>" required class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">No. Telp</label>
                <input type="text" name="no_telp" value="<?php echo $edit_data ? $edit_data['no_telp'] : ''; ?>" required class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
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
            <button type="submit" class="bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700">Simpan</button>
            <?php if ($edit_data) { ?>
                <a href="?open=data_siswa" class="bg-gray-600 text-white p-2 rounded-lg hover:bg-gray-700">Batal</a>
            <?php } ?>
        </form>
    </div>

    <!-- Tabel Read -->
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Daftar Siswa</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">NISN</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">NIS</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kelas</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Alamat</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">No. Telp</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">SPP</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td class="px-4 py-2"><?php echo $row['nisn']; ?></td>
                            <td class="px-4 py-2"><?php echo $row['nis']; ?></td>
                            <td class="px-4 py-2"><?php echo $row['nama']; ?></td>
                            <td class="px-4 py-2"><?php echo $row['nama_kelas']; ?></td>
                            <td class="px-4 py-2"><?php echo $row['alamat']; ?></td>
                            <td class="px-4 py-2"><?php echo $row['no_telp']; ?></td>
                            <td class="px-4 py-2"><?php echo $row['tahun']; ?></td>
                            <td class="px-4 py-2">
                                <a href="?open=data_siswa&edit=<?php echo $row['nisn']; ?>" class="text-blue-600 hover:underline">Edit</a>
                                <a href="?open=data_siswa&delete=<?php echo $row['nisn']; ?>" class="text-red-600 hover:underline ml-2" onclick="return confirm('Yakin hapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>