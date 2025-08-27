<?php
require_once 'includes/header.php';
require_once 'includes/navbar.php';
require_once 'includes/functions.php';

// Mengambil pengumuman terbaru
$announcements = fetchAll("SELECT * FROM announcements ORDER BY created_at DESC LIMIT 3");

// Mengambil kegiatan terbaru
$activities = fetchAll("SELECT * FROM activities ORDER BY date DESC LIMIT 3");

// Mengambil data statistik warga
$totalResidents = fetchOne("SELECT COUNT(*) as total FROM residents")['total'];
$maleResidents = fetchOne("SELECT COUNT(*) as total FROM residents WHERE gender = 'L'")['total'];
$femaleResidents = fetchOne("SELECT COUNT(*) as total FROM residents WHERE gender = 'P'")['total'];
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content">
                    <h1>Selamat Datang di Website RT 01</h1>
                    <p class="lead">Portal informasi dan layanan untuk warga RT 01 Kelurahan Contoh</p>
                    <a href="/pages/about.php" class="btn btn-light btn-lg">
                        <i class="bi bi-info-circle"></i> Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="text-center">
                    <img src="https://via.placeholder.com/500x400" alt="RT 01" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h2 class="text-gradient">Statistik Kependudukan</h2>
                <p class="text-muted">Data terkini jumlah warga RT 01</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="bi bi-people-fill"></i>
                    <h3><?php echo $totalResidents; ?></h3>
                    <p>Total Warga</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="bi bi-person-fill"></i>
                    <h3><?php echo $maleResidents; ?></h3>
                    <p>Laki-laki</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="bi bi-person-fill"></i>
                    <h3><?php echo $femaleResidents; ?></h3>
                    <p>Perempuan</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h2 class="text-gradient">Layanan Kami</h2>
                <p class="text-muted">Berbagai layanan yang tersedia untuk warga RT 01</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="bi bi-people"></i>
                    <h5>Data Kependudukan</h5>
                    <p>Informasi lengkap data warga RT 01 yang terupdate</p>
                    <a href="/pages/residents.php" class="btn btn-primary btn-sm">Selengkapnya</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="bi bi-cash-stack"></i>
                    <h5>Keuangan RT</h5>
                    <p>Transparansi pemasukan dan pengeluaran kas RT</p>
                    <a href="/pages/finance.php" class="btn btn-primary btn-sm">Selengkapnya</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="bi bi-calendar-event"></i>
                    <h5>Kegiatan Sosial</h5>
                    <p>Jadwal dan informasi kegiatan kemasyarakatan</p>
                    <a href="/pages/activities.php" class="btn btn-primary btn-sm">Selengkapnya</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="bi bi-megaphone"></i>
                    <h5>Pengumuman</h5>
                    <p>Informasi penting dan pengumuman terkini</p>
                    <a href="/pages/announcements.php" class="btn btn-primary btn-sm">Selengkapnya</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Recent Announcements & Activities -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-4">
                    <h3 class="text-gradient mb-4">Pengumuman Terbaru</h3>
                    <?php if (count($announcements) > 0): ?>
                        <?php foreach ($announcements as $announcement): ?>
                            <div class="card">
                                <div class="card-body">
                                    <h5><?php echo $announcement['title']; ?></h5>
                                    <div class="date">
                                        <i class="bi bi-calendar3"></i> <?php echo formatDate($announcement['created_at']); ?>
                                    </div>
                                    <div class="content">
                                        <?php echo substr($announcement['content'], 0, 150) . '...'; ?>
                                    </div>
                                    <a href="/pages/announcements.php?id=<?php echo $announcement['id']; ?>" class="btn btn-primary btn-sm">
                                        <i class="bi bi-arrow-right"></i> Baca Selengkapnya
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div class="text-end mt-3">
                            <a href="/pages/announcements.php" class="btn btn-outline-primary">
                                <i class="bi bi-list-ul"></i> Lihat Semua
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Belum ada pengumuman
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-4">
                    <h3 class="text-gradient mb-4">Kegiatan Terbaru</h3>
                    <?php if (count($activities) > 0): ?>
                        <?php foreach ($activities as $activity): ?>
                            <div class="card">
                                <div class="card-body">
                                    <h5><?php echo $activity['title']; ?></h5>
                                    <div class="date">
                                        <i class="bi bi-calendar3"></i> <?php echo formatDate($activity['date']); ?>
                                        <span class="ms-3">
                                            <i class="bi bi-geo-alt"></i> <?php echo $activity['location']; ?>
                                        </span>
                                    </div>
                                    <div class="content">
                                        <?php echo substr($activity['description'], 0, 150) . '...'; ?>
                                    </div>
                                    <a href="/pages/activities.php?id=<?php echo $activity['id']; ?>" class="btn btn-info btn-sm">
                                        <i class="bi bi-arrow-right"></i> Detail Kegiatan
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div class="text-end mt-3">
                            <a href="/pages/activities.php" class="btn btn-outline-info">
                                <i class="bi bi-list-ul"></i> Lihat Semua
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Belum ada kegiatan
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Links Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h2 class="text-gradient">Akses Cepat</h2>
                <p class="text-muted">Menuju ke halaman yang sering dikunjungi</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <a href="/pages/residents.php" class="btn btn-primary w-100 py-3">
                    <i class="bi bi-people d-block mb-2" style="font-size: 2rem;"></i>
                    Data Warga
                </a>
            </div>
            <div class="col-md-3">
                <a href="/pages/finance.php" class="btn btn-success w-100 py-3">
                    <i class="bi bi-cash-stack d-block mb-2" style="font-size: 2rem;"></i>
                    Keuangan
                </a>
            </div>
            <div class="col-md-3">
                <a href="/pages/activities.php" class="btn btn-info w-100 py-3">
                    <i class="bi bi-calendar-event d-block mb-2" style="font-size: 2rem;"></i>
                    Kegiatan
                </a>
            </div>
            <div class="col-md-3">
                <a href="/pages/announcements.php" class="btn btn-warning w-100 py-3">
                    <i class="bi bi-megaphone d-block mb-2" style="font-size: 2rem;"></i>
                    Pengumuman
                </a>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>