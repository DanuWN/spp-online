<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPP Online - SMKN 3 Banjarbaru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .sidebar {
            transition: all 0.3s ease-in-out;
        }
        .sidebar a:hover {
            background-color: #2563eb;
            color: white;
        }
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .status-admin {
            background-color: #10b981;
            color: white;
        }
        .status-petugas {
            background-color: #3b82f6;
            color: white;
        }
        @media (max-width: 640px) {
            .sidebar {
                width: 100%;
                height: auto;
            }
            .sidebar nav {
                display: flex;
                flex-direction: column;
            }
            .content {
                padding: 0.5rem;
            }
            .content header, .content div {
                padding: 1rem;
            }
            .text-3xl {
                font-size: 1.25rem;
            }
            .text-xl {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <?php
    session_start();
    include 'src/koneksi.php';

    // Cek apakah user sudah login
    if (isset($_SESSION['username']) && isset($_SESSION['level'])) {
        // Dashboard Admin
        ?>
        <div class="min-h-screen flex flex-col sm:flex-row">
            <!-- Sidebar -->
            <aside class="sidebar bg-white w-full sm:w-64 min-h-screen sm:min-h-screen shadow-lg">
                <div class="p-4 sm:p-6">
                    <h2 class="text-base sm:text-xl font-semibold text-gray-800">Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
                    <p class="mt-2">
                        <span class="status-badge <?php echo $_SESSION['level'] == 'admin' ? 'status-admin' : 'status-petugas'; ?>">
                            Status: <?php echo ucfirst($_SESSION['level']); ?>
                        </span>
                    </p>
                    <p class="text-gray-600 mt-2 text-sm sm:text-base">Aplikasi Pembayaran SPP SMKN 3 Banjarbaru</p>
                </div>
                <nav class="mt-4">
                    <ul class="space-y-2">
                        <li><a href="?open=informasi_utama" class="block px-4 sm:px-6 py-2 sm:py-3 text-gray-700 hover:bg-blue-600 hover:text-white rounded">Beranda</a></li>
                        <li><a href="?open=data_spp" class="block px-4 sm:px-6 py-2 sm:py-3 text-gray-700 hover:bg-blue-600 hover:text-white rounded">SPP</a></li>
                        <li><a href="?open=data_kelas" class="block px-4 sm:px-6 py-2 sm:py-3 text-gray-700 hover:bg-blue-600 hover:text-white rounded">Kelas</a></li>
                        <li><a href="?open=data_siswa" class="block px-4 sm:px-6 py-2 sm:py-3 text-gray-700 hover:bg-blue-600 hover:text-white rounded">Siswa</a></li>
                        <li><a href="?open=data_pembayaran" class="block px-4 sm:px-6 py-2 sm:py-3 text-gray-700 hover:bg-blue-600 hover:text-white rounded">Pembayaran</a></li>
                        <li><a href="?open=data_petugas" class="block px-4 sm:px-6 py-2 sm:py-3 text-gray-700 hover:bg-blue-600 hover:text-white rounded">Petugas</a></li>
                        <li><a href="?open=logout" class="block px-4 sm:px-6 py-2 sm:py-3 text-gray-700 hover:bg-red-600 hover:text-white rounded">Logout</a></li>
                    </ul>
                </nav>
            </aside>

            <!-- Konten Utama -->
            <div class="flex-1 p-4 sm:p-8 content">
                <header class="bg-white shadow p-4 sm:p-6 rounded-lg">
                    <h1 class="text-lg sm:text-3xl font-bold text-gray-800">Pembayaran SPP Online SMKN 3 Banjarbaru</h1>
                </header>
                <div class="mt-4 sm:mt-6 bg-white p-4 sm:p-6 rounded-lg shadow">
                    <?php
                    // Logika inklusi file
                    $open = isset($_GET['open']) ? $_GET['open'] : 'informasi_utama';
                    $file = 'admin/informasi_utama.php'; // File default

                    // Daftar kemungkinan path untuk informasi_utama.php
                    $possible_paths = [
                        'admin/informasi_utama.php',
                        'informasi_utama.php',
                        'src/informasi_utama.php',
                        './admin/informasi_utama.php'
                    ];

                    switch ($open) {
                        case 'data_spp':
                        case 'data_kelas':
                        case 'data_siswa':
                        case 'data_pembayaran':
                        case 'data_petugas':
                            $file = 'admin/' . $open . '.php'; // Asumsi file lain juga di admin/
                            break;
                        case 'logout':
                            session_destroy();
                            header("Location: index.php?pesan=logout");
                            exit;
                        case 'informasi_utama':
                        default:
                            $file = 'admin/informasi_utama.php';
                            break;
                    }

                    // Cek keberadaan file di path yang mungkin
                    $file_found = false;
                    if ($open === 'informasi_utama' || $open === '') {
                        foreach ($possible_paths as $path) {
                            if (file_exists($path)) {
                                $file = $path;
                                $file_found = true;
                                break;
                            }
                        }
                    } elseif (file_exists($file)) {
                        $file_found = true;
                    }

                    if ($file_found) {
                        include $file;
                    } else {
                        echo "<p class='text-red-500'>Halaman tidak ditemukan! File: $file</p>";
                        echo "<p class='text-gray-500'>Debug: Direktori saat ini: " . getcwd() . "</p>";
                        echo "<p class='text-gray-500'>Debug: Path file yang dicoba: $file</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    } else {
        // Halaman Login
        ?>
        <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-500 to-indigo-600">
            <div class="bg-white p-6 sm:p-8 rounded-lg shadow-lg w-full max-w-md">
                <h1 class="text-xl sm:text-2xl font-bold text-center text-gray-800 mb-6">SPP Online Login</h1>
                
                <?php
                if (isset($_GET['pesan'])) {
                    $message = '';
                    $color = '';
                    if ($_GET['pesan'] == "gagal") {
                        $message = "Username atau Password salah!";
                        $color = "text-red-500";
                    } elseif ($_GET['pesan'] == "logout") {
                        $message = "Anda telah berhasil logout";
                        $color = "text-green-500";
                    } elseif ($_GET['pesan'] == "belum_login") {
                        $message = "Anda harus login terlebih dahulu";
                        $color = "text-orange-500";
                    }
                    echo "<div class='$color mb-4 text-center'>$message</div>";
                }
                ?>

                <form action="login_validasi.php" method="post" class="space-y-4">
                    <div>
                        <input name="username" type="text" placeholder="Username" required class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <input name="password" type="password" placeholder="Password" required class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <button type="submit" name="login" class="w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700 transition">Login</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }
    ?>
</body>
</html>