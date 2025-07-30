<?php
session_start();
include './src/koneksi.php';

if (!isset($_SESSION['username']) || !isset($_SESSION['level'])) {
    header("Location: ../index.php?pesan=belum_login");
    exit;
}

// Create atau Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tahun = mysqli_real_escape_string($koneksi, $_POST['tahun']);
    $nominal = mysqli_real_escape_string($koneksi, $_POST['nominal']);
    
    if (isset($_POST['id_spp']) && !empty($_POST['id_spp'])) {
        // Update
        $id_spp = mysqli_real_escape_string($koneksi, $_POST['id_spp']);
        $query = "UPDATE spp SET tahun='$tahun', nominal='$nominal' WHERE id_spp='$id_spp'";
    } else {
        // Create
        $query = "INSERT INTO spp (tahun, nominal) VALUES ('$tahun', '$nominal')";
    }
    
    mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));
    echo "<script>alert('Data SPP berhasil disimpan'); window.location='?open=data_spp';</script>";
}

// Delete
if (isset($_GET['delete'])) {
    $id_spp = mysqli_real_escape_string($koneksi, $_GET['delete']);
    mysqli_query($koneksi, "DELETE FROM spp WHERE id_spp='$id_spp'") or die(mysqli_error($koneksi));
    echo "<script>alert('Data SPP berhasil dihapus'); window.location='?open=data_spp';</script>";
}

// Edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $id_spp = mysqli_real_escape_string($koneksi, $_GET['edit']);
    $edit_data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM spp WHERE id_spp='$id_spp'"));
}

// Read
$result = mysqli_query($koneksi, "SELECT * FROM spp") or die(mysqli_error($koneksi));
?>

<div class="container mx-auto">
    <h2 class="text-xl sm:text-2xl font-bold mb-4">Data SPP</h2>
    
    <!-- Form Create/Update -->
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow mb-6">
        <h3 class="text-lg font-semibold mb-4"><?php echo $edit_data ? 'Edit' : 'Tambah'; ?> SPP</h3>
        <form action="" method="post" class="space-y-4">
            <input type="hidden" name="id_spp" value="<?php echo $edit_data ? $edit_data['id_spp'] : ''; ?>">
            <div>
                <label class="block text-sm font-medium text-gray-700">Tahun</label>
                <input type="number" name="tahun" value="<?php echo $edit_data ? $edit_data['tahun'] : ''; ?>" required class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Nominal</label>
                <input type="number" name="nominal" value="<?php echo $edit_data ? $edit_data['nominal'] : ''; ?>" required class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700">Simpan</button>
            <?php if ($edit_data) { ?>
                <a href="?open=data_spp" class="bg-gray-600 text-white p-2 rounded-lg hover:bg-gray-700">Batal</a>
            <?php } ?>
        </form>
    </div>

    <!-- Tabel Read -->
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Daftar SPP</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tahun</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nominal</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td class="px-4 py-2"><?php echo $row['tahun']; ?></td>
                            <td class="px-4 py-2"><?php echo number_format($row['nominal'], 0, ',', '.'); ?></td>
                            <td class="px-4 py-2">
                                <a href="?open=data_spp&edit=<?php echo $row['id_spp']; ?>" class="text-blue-600 hover:underline">Edit</a>
                                <a href="?open=data_spp&delete=<?php echo $row['id_spp']; ?>" class="text-red-600 hover:underline ml-2" onclick="return confirm('Yakin hapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>