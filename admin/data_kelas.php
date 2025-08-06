<?php
$koneksi = new mysqli("localhost", "root", "", "db_akhir");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Tambah atau Update Data
if (isset($_POST['submit'])) {
    $id_kelas = htmlspecialchars(trim($_POST['id_kelas']));
    $nama_kelas = htmlspecialchars(trim($_POST['nama_kelas']));
    $kompetensi_keahlian = htmlspecialchars(trim($_POST['kompetensi_keahlian']));

    if (isset($_GET['edit'])) { // Update
        $stmt = $koneksi->prepare("UPDATE kelas SET nama_kelas = ?, kompetensi_keahlian = ? WHERE id_kelas = ?");
        $stmt->bind_param("ssi", $nama_kelas, $kompetensi_keahlian, $id_kelas);
        if ($stmt->execute()) {
            echo "<script>alert('Data Kelas berhasil diperbarui'); window.location='?open=data_kelas';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat memperbarui data');</script>";
        }
        $stmt->close();
    } else { // Insert
        $stmt = $koneksi->prepare("SELECT * FROM kelas WHERE id_kelas = ? OR (nama_kelas = ? AND kompetensi_keahlian = ?)");
        $stmt->bind_param("iss", $id_kelas, $nama_kelas, $kompetensi_keahlian);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('ID Kelas, Nama Kelas, atau Kompetensi Keahlian sudah ada'); window.location='?open=data_kelas';</script>";
        } else {
            $stmt = $koneksi->prepare("INSERT INTO kelas (id_kelas, nama_kelas, kompetensi_keahlian) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $id_kelas, $nama_kelas, $kompetensi_keahlian);
            if ($stmt->execute()) {
                echo "<script>alert('Data Kelas berhasil ditambahkan'); window.location='?open=data_kelas';</script>";
            } else {
                echo "<script>alert('Terjadi kesalahan saat menambahkan data');</script>";
            }
        }
        $stmt->close();
    }
}

// Delete
if (isset($_GET['delete'])) {
    $id_kelas = htmlspecialchars(trim($_GET['delete']));
    $stmt = $koneksi->prepare("SELECT * FROM siswa WHERE id_kelas = ?");
    $stmt->bind_param("i", $id_kelas);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Gagal menghapus: Kelas ini masih digunakan oleh siswa'); window.location='?open=data_kelas';</script>";
    } else {
        $stmt = $koneksi->prepare("DELETE FROM kelas WHERE id_kelas = ?");
        $stmt->bind_param("i", $id_kelas);
        if ($stmt->execute()) {
            echo "<script>alert('Data Kelas berhasil dihapus'); window.location='?open=data_kelas';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat menghapus data');</script>";
        }
    }
    $stmt->close();
}

// Read
$result = $koneksi->query("SELECT * FROM kelas");

// Edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $id_kelas = htmlspecialchars(trim($_GET['edit']));
    $stmt = $koneksi->prepare("SELECT * FROM kelas WHERE id_kelas = ?");
    $stmt->bind_param("i", $id_kelas);
    $stmt->execute();
    $edit_data = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}
?>

<div class="container mx-auto p-4">
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4"><?php echo $edit_data ? 'Edit Kelas' : 'Tambah Kelas'; ?></h3>
        <form method="POST">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">ID Kelas</label>
                <input type="number" name="id_kelas" value="<?php echo $edit_data ? htmlspecialchars($edit_data['id_kelas']) : ''; ?>" <?php echo $edit_data ? 'readonly' : ''; ?> required class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Kelas</label>
                <input type="text" name="nama_kelas" value="<?php echo $edit_data ? htmlspecialchars($edit_data['nama_kelas']) : ''; ?>" required class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Kompetensi Keahlian</label>
                <input type="text" name="kompetensi_keahlian" value="<?php echo $edit_data ? htmlspecialchars($edit_data['kompetensi_keahlian']) : ''; ?>" required class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" name="submit" class="bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700">Simpan</button>
            <?php if ($edit_data) { ?>
                <a href="?open=data_kelas" class="bg-gray-600 text-white p-2 rounded-lg hover:bg-gray-700">Batal</a>
            <?php } ?>
        </form>
    </div>

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
                    <?php while ($row = $result->fetch_assoc()) { ?>
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