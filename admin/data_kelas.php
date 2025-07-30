<?php
include './src/koneksi.php';

if (!isset($_SESSION['username']) || !isset($_SESSION['level'])) {
    header("Location: ../index.php?pesan=belum_login");
    exit;
}

// Create atau Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_kelas = mysqli_real_escape_string($koneksi, $_POST['nama_kelas']);
    $kompetensi_keahlian = mysqli_real_escape_string($koneksi, $_POST['kompetensi_keahlian']);
    $id_kelas = isset($_POST['id_kelas']) ? mysqli_real_escape_string($koneksi, $_POST['id_kelas']) : '';

    if (!empty($id_kelas)) {
        // Update
        $query = "UPDATE kelas SET nama_kelas='$nama_kelas', kompetensi_keahlian='$kompetensi_keahlian' WHERE id_kelas='$id_kelas'";
        mysqli_query($koneksi, $query) or die("Error update: " . mysqli_error($koneksi));
        echo "<script>alert('Data Kelas berhasil diperbarui'); window.location='?open=data_kelas';</script>";
    } else {
        // Create
        $query = "INSERT INTO kelas (nama_kelas, kompetensi_keahlian) VALUES ('$nama_kelas', '$kompetensi_keahlian')";
        mysqli_query($koneksi, $query) or die("Error insert: " . mysqli_error($koneksi));
        echo "<script>alert('Data Kelas berhasil ditambahkan'); window.location='?open=data_kelas';</script>";
    }
}

// Delete
if (isset($_GET['delete'])) {
    $id_kelas = mysqli_real_escape_string($koneksi, $_GET['delete']);
    // Cek apakah id_kelas digunakan di tabel siswa
    $check = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_kelas='$id_kelas'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Gagal menghapus: Kelas ini masih digunakan oleh siswa'); window.location='?open=data_kelas';</script>";
    } else {
        mysqli_query($koneksi, "DELETE FROM kelas WHERE id_kelas='$id_kelas'") or die("Error delete: " . mysqli_error($koneksi));
        echo "<script>alert('Data Kelas berhasil dihapus'); window.location='?open=data_kelas';</script>";
    }
}

// Edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $id_kelas = mysqli_real_escape_string($koneksi, $_GET['edit']);
    $edit_data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM kelas WHERE id_kelas='$id_kelas'"));
    if (!$edit_data) {
        echo "<script>alert('Data Kelas tidak ditemukan'); window.location='?open=data_kelas';</script>";
    }
}

// Read
$result = mysqli_query($koneksi, "SELECT * FROM kelas") or die("Error read: " . mysqli_error($koneksi));
?>

<div class="container mx-auto">
    <h2 class="text-xl sm:text-2xl font-bold mb-4">Data Kelas</h2>
    
    <!-- Form Create/Update -->
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow mb-6">
        <h3 class="text-lg font-semibold mb-4"><?php echo $edit_data ? 'Edit' : 'Tambah'; ?> Kelas</h3>
        <form action="?open=data_kelas" method="post" class="space-y-4">
            <input type="hidden" name="id_kelas" value="<?php echo $edit_data ? htmlspecialchars($edit_data['id_kelas']) : ''; ?>">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Kelas</label>
                <input type="text" name="nama_kelas" value="<?php echo $edit_data ? htmlspecialchars($edit_data['nama_kelas']) : ''; ?>" required class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Kompetensi Keahlian</label>
                <input type="text" name="kompetensi_keahlian" value="<?php echo $edit_data ? htmlspecialchars($edit_data['kompetensi_keahlian']) : ''; ?>" required class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700">Simpan</button>
            <?php if ($edit_data) { ?>
                <a href="?open=data_kelas" class="bg-gray-600 text-white p-2 rounded-lg hover:bg-gray-700">Batal</a>
            <?php } ?>
        </form>
    </div>

    <!-- Tabel Read -->
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Daftar Kelas</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID Kelas</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama Kelas</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kompetensi Keahlian</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td class="px-4 py-2"><?php echo htmlspecialchars($row['id_kelas']); ?></td>
                            <td class="px-4 py-2"><?php echo htmlspecialchars($row['nama_kelas']); ?></td>
                            <td class="px-4 py-2"><?php echo htmlspecialchars($row['kompetensi_keahlian']); ?></td>
                            <td class="px-4 py-2">
                                <a href="?open=data_kelas&edit=<?php echo htmlspecialchars($row['id_kelas']); ?>" class="text-blue-600 hover:underline">Edit</a>
                                <a href="?open=data_kelas&delete=<?php echo htmlspecialchars($row['id_kelas']); ?>" class="text-red-600 hover:underline ml-2" onclick="return confirm('Yakin hapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>