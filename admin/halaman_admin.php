<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    session_start();
    if ($_SESSION['level'] != "") {
        header("location:index.php?pesan=belum_login");
    }
    ?>
    <header>
        <h1>Pembayaran spp online smkn 3 banjarbaru</h1>
    </header>

    <div>
        <nav>
            <?php include 'menu.php'; ?>
        </nav>
    </div>

    <aside class="sidebar">
        <div class="widget">
            <h2>Sealamat Datang, <?php echo $_SESSION['username']; ?></h2>
            <p>Selamat datang di aplikasi pembayaran spp smkn 3 banjarbaru</p>
        </div>
    </aside>

    <div class="blog">
        <div class="conteudo">
            <?php include 'buka_file.php'; ?>
        </div>
    </div>
</body>
</html>