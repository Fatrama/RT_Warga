<?php
require_once 'includes/header.php';
require_once 'includes/navbar.php';
require_once 'includes/auth.php';

// Hanya user yang sudah login yang bisa akses
requireLogin();

// Konten khusus untuk user yang sudah login
?>
<div class="container mt-4">
    <h1>Selamat Datang, <?php echo $_SESSION['username']; ?></h1>
    <p>Ini adalah halaman beranda pribadi Anda</p>
    <!-- Konten lainnya -->
</div>
<?php require_once 'includes/footer.php'; ?>