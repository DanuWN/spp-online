<?php
session_start();
include './src/koneksi.php';

if (!isset($_SESSION['username']) || !isset($_SESSION['level'])) {
    header("Location: ../index.php?pesan=belum_login");
    exit;
}

// Hanya admin yang bisa akses
if ($_SESSION['level'] != 'admin') {
    echo "<script>alert('Hanya admin yang bisa mengakses data petugas'); window.location='?open=informasi_utama';</script>";
    exit;
}

// Create atau Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = !empty($_POST['password']) ? md5($_POST['password']) : null; // Note: MD5 is insecure
    $nama_petugas = mysqli_real_escape_string($koneksi, $_POST['nama_petugas']);
    $level = mysqli_real_escape_string($koneksi, $_POST['level']);
    
    if (isset($_POST['id_petugas']) && !empty($_POST['id_petugas'])) {
        // Update
        $id_petugas = mysqli_real_escape_string($koneksi, $_POST['id_petugas']);
        if ($password) {
            $query = "UPDATE petugas SET username='$username', password='$password', nama_petugas='$nama_petugas', level='$level' WHERE id_petugas='$id_petugas'";
        } else {
            $query = "UPDATE petugas SET username='$username', nama_petugas='$nama_petugas', level='$level' WHERE id_petugas='$id_petugas'";
        }
    } else {
        // Create
        $query = "INSERT INTO petugas (username, password, nama_petugas, level) VALUES ('$username', '$password', '$nama_petugas', '$level')";
    }
    
    mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));
    echo "<script>alert('Data Petugas berhasil disimpan'); window.location='?open=data_petugas';</script>";
}

// Delete
if (isset($_GET['delete'])) {
    $id_petugas = mysqli_real_escape_string($koneksi, $_GET['delete']);
    mysqli_query($koneksi, "DELETE FROM petugas WHERE id_petugas='$id_petugas'") or die(mysqli_error($koneksi));
    echo "<script>alert('Data Petugas berhasil dihapus'); window.location='?open=data_petugas';</script>";
}

// Edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $id_petugas = mysqli_real_escape_string($koneksi, $_GET['edit']);
    $edit_data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM petugas WHERE id_petugas='$id_petugas'"));
}

// Read
$result = mysqli_query($koneksi, "SELECT * FROM petugas") or die(mysqli_error($koneksi));
?>

<div class="container mx-auto">
    <h2 class="text-xl sm:text-2xl font-bold mb-4">Data Petugas</h2>
    
    <!-- Form Create/Update -->
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow mb-6">
        <h3 class="text-lg font-semibold mb-4"><?php echo $edit_data ? 'Edit' : 'Tambah'; ?> Petugas</h3>
        <form action="" method="post" class="space-y-4">
            <input type="hidden" name="id_petugas" value="<?php echo $edit_data ? $edit_data['id_petugas'] : ''; ?>">
            <div>
                <label class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" value="<?php echo $edit_data ? $edit_data['username'] : ''; ?>" required class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" <?php echo $edit_data ? '' : 'required'; ?> class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <?php if ($edit_data) { ?>
                    <p class="text-sm text-gray-500">Kosongkan jika tidak ingin mengubah password</p>
                <?php } ?>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Petugas</label>
                <input type="text" name="nama_petugas" value="<?php echo $edit_data ? $edit_data['nama_petugas'] : ''; ?>" required class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Level</label>
                <select name="level" required class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="admin" <?php echo $edit_data && $edit_data['level'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                    <option value="petugas" <?php echo $edit_data && $edit_data['level'] == 'petugas' ? 'selected' : ''; ?>>Petugas</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700">Simpan</button>
            <?php if ($edit_data) { ?>
                <a href="?open=data_petugas" class="bg-gray-600 text-white p-2 rounded-lg hover:bg-gray-700">Batal</a>
            <?php } ?>
        </form>
    </div>

    <!-- Tabel Read -->
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Daftar Petugas</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Username</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama Petugas</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Level</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td class="px-4 py-2"><?php echo $row['username']; ?></td>
                            <td class="px-4 py-2"><?php echo $row['nama_petugas']; ?></td>
                            <td class="px-4 py-2"><?php echo ucfirst($row['level']); ?></td>
                            <td class="px-4 py-2">
                                <a href="?open=data_petugas&edit=<?php echo $row['id_petugas']; ?>" class="text-blue-600 hover:underline">Edit</a>
                                <a href="?open=data_petugas&delete=<?php echo $row['id_petugas']; ?>" class="text-red-600 hover:underline ml-2" onclick="return confirm('Yakin hapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>