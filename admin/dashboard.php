<?php
session_start();
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: /pages/login.php');
    exit;
}
// Check if user is admin
if ($_SESSION['user_role'] != 'admin') {
    header('Location: /index.php');
    exit;
}
// Include database connection
require_once __DIR__ . '/../config/database.php';
// Get statistics
$totalResidents = $pdo->query("SELECT COUNT(*) FROM residents")->fetchColumn();
$totalActivities = $pdo->query("SELECT COUNT(*) FROM activities")->fetchColumn();
$totalAnnouncements = $pdo->query("SELECT COUNT(*) FROM announcements")->fetchColumn();
// Get total income and expense
$totalIncome = $pdo->query("SELECT SUM(amount) FROM finance WHERE type = 'income'")->fetchColumn() ?? 0;
$totalExpense = $pdo->query("SELECT SUM(amount) FROM finance WHERE type = 'expense'")->fetchColumn() ?? 0;
$balance = $totalIncome - $totalExpense;
// Get total monthly dues
$totalMonthlyDues = $pdo->query("SELECT SUM(amount) FROM monthly_dues")->fetchColumn() ?? 0;
$monthlyDuesCount = $pdo->query("SELECT COUNT(*) FROM monthly_dues")->fetchColumn() ?? 0;
// Get recent activities
$recentActivities = $pdo->query("SELECT * FROM activities ORDER BY date DESC LIMIT 5")->fetchAll();
// Get recent announcements
$recentAnnouncements = $pdo->query("SELECT * FROM announcements ORDER BY created_at DESC LIMIT 5")->fetchAll();
// Get recent monthly dues
$recentMonthlyDues = $pdo->query("SELECT md.*, r.name FROM monthly_dues md JOIN residents r ON md.resident_id = r.id ORDER BY md.date DESC LIMIT 5")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - RT 009</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background: linear-gradient(135deg, #1e3c72, #2a5298) !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .dashboard-header {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
            height: 100%;
            border-left: 5px solid;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .stat-card.primary i {
            color: #1e3c72;
        }
        
        .stat-card.success i {
            color: #28a745;
        }
        
        .stat-card.info i {
            color: #17a2b8;
        }
        
        .stat-card.warning i {
            color: #ffc107;
        }
        
        .stat-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #343a40;
        }
        
        .stat-card p {
            color: #6c757d;
            margin-bottom: 1rem;
        }
        
        .dashboard-actions {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .recent-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }
        
        .recent-item {
            padding: 1rem 0;
            border-bottom: 1px solid #dee2e6;
        }
        
        .recent-item:last-child {
            border-bottom: none;
        }
        
        .btn-action {
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .btn-info {
            background: linear-gradient(135deg, #17a2b8, #138496);
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .btn-warning {
            background: linear-gradient(135deg, #ffc107, #e0a800);
            color: #343a40;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .btn-outline-primary {
            border: 2px solid #1e3c72;
            color: #1e3c72;
            background: transparent;
        }
        
        .btn-outline-primary:hover {
            background: #1e3c72;
            color: white;
        }
        
        .badge {
            padding: 0.5rem 0.75rem;
            font-weight: 500;
        }
        
        @media (max-width: 768px) {
            .dashboard-header {
                padding: 1.5rem;
            }
            
            .dashboard-header h2 {
                font-size: 1.5rem;
            }
            
            .stat-card {
                margin-bottom: 1rem;
            }
            
            .btn-action {
                font-size: 0.875rem;
                padding: 0.5rem 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/index.php">
                <i class="bi bi-building"></i> RT 01
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/index.php">
                            <i class="bi bi-house-door"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/process/logout.php">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Main Content -->
    <div class="container mt-4">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-0">
                        <i class="bi bi-speedometer2"></i> Dashboard Admin
                    </h2>
                    <p class="mb-0 opacity-75">
                        Selamat datang, <?php echo $_SESSION['username']; ?>! | <?php echo date('d F Y H:i'); ?>
                    </p>
                </div>
                <div class="col-md-4 text-end">
                    <span class="badge bg-light text-primary p-2">
                        <i class="bi bi-person-badge"></i> <?php echo ucfirst($_SESSION['role']); ?>
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-md-3">
                <div class="stat-card primary">
                    <i class="bi bi-people-fill"></i>
                    <h3><?php echo $totalResidents; ?></h3>
                    <p>Total Warga</p>
                    <a href="/admin/residents.php" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-arrow-right"></i> Kelola
                    </a>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="stat-card success">
                    <i class="bi bi-calendar-event-fill"></i>
                    <h3><?php echo $totalActivities; ?></h3>
                    <p>Kegiatan</p>
                    <a href="/admin/activities.php" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-arrow-right"></i> Kelola
                    </a>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="stat-card info">
                    <i class="bi bi-megaphone-fill"></i>
                    <h3><?php echo $totalAnnouncements; ?></h3>
                    <p>Pengumuman</p>
                    <a href="/admin/announcements.php" class="btn btn-outline-info btn-sm">
                        <i class="bi bi-arrow-right"></i> Kelola
                    </a>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="stat-card warning">
                    <i class="bi bi-cash-stack"></i>
                    <h3>Rp <?php echo number_format($balance, 0, ',', '.'); ?></h3>
                    <p>Saldo Kas</p>
                    <a href="/admin/finance.php" class="btn btn-outline-warning btn-sm">
                        <i class="bi bi-arrow-right"></i> Kelola
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Monthly Dues Card -->
        <div class="row mt-2">
            <div class="col-md-3">
                <div class="stat-card" style="border-left: 5px solid #6f42c1;">
                    <i class="bi bi-wallet2" style="color: #6f42c1;"></i>
                    <h3>Rp <?php echo number_format($totalMonthlyDues, 0, ',', '.'); ?></h3>
                    <p>Total Iuran Bulanan</p>
                    <a href="/admin/monthly_dues.php" class="btn btn-sm" style="background-color: #6f42c1; color: white;">
                        <i class="bi bi-arrow-right"></i> Kelola
                    </a>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="stat-card" style="border-left: 5px solid #fd7e14;">
                    <i class="bi bi-receipt" style="color: #fd7e14;"></i>
                    <h3><?php echo $monthlyDuesCount; ?></h3>
                    <p>Transaksi Iuran</p>
                    <a href="/admin/monthly_dues.php" class="btn btn-sm" style="background-color: #fd7e14; color: white;">
                        <i class="bi bi-arrow-right"></i> Lihat
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="dashboard-actions">
            <h5><i class="bi bi-lightning-charge"></i> Aksi Cepat</h5>
            <div class="row">
                <div class="col-md-3">
                    <a href="/admin/add_resident.php" class="btn btn-primary w-100">
                        <i class="bi bi-person-plus"></i> Tambah Warga
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="/admin/add_finance.php" class="btn btn-success w-100">
                        <i class="bi bi-cash-coin"></i> Tambah Transaksi
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="/admin/add_monthly_due.php" class="btn w-100" style="background-color: #6f42c1; color: white;">
                        <i class="bi bi-wallet2"></i> Tambah Iuran
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="/admin/add_activity.php" class="btn btn-info w-100">
                        <i class="bi bi-calendar-plus"></i> Tambah Kegiatan
                    </a>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-3">
                    <a href="/admin/add_announcement.php" class="btn btn-warning w-100">
                        <i class="bi bi-megaphone"></i> Tambah Pengumuman
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Recent Activities & Announcements & Monthly Dues -->
        <div class="row">
            <div class="col-md-6">
                <div class="recent-card">
                    <h5>
                        <i class="bi bi-calendar3"></i> Kegiatan Terbaru
                        <a href="/admin/activities.php" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                    </h5>
                    <?php if (count($recentActivities) > 0): ?>
                        <?php foreach ($recentActivities as $activity): ?>
                            <div class="recent-item">
                                <h6><?php echo $activity['title']; ?></h6>
                                <p><i class="bi bi-geo-alt"></i> <?php echo $activity['location']; ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small><?php echo date('d/m/Y', strtotime($activity['date'])); ?></small>
                                    <?php
                                    $statusClass = '';
                                    $statusText = '';
                                    switch($activity['status']) {
                                        case 'upcoming':
                                            $statusClass = 'bg-info';
                                            $statusText = 'Akan Datang';
                                            break;
                                        case 'ongoing':
                                            $statusClass = 'bg-warning';
                                            $statusText = 'Berlangsung';
                                            break;
                                        case 'completed':
                                            $statusClass = 'bg-success';
                                            $statusText = 'Selesai';
                                            break;
                                    }
                                    ?>
                                    <span class="badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center p-4">
                            <p class="text-muted">Belum ada kegiatan</p>
                            <a href="/admin/add_activity.php" class="btn btn-sm btn-info">
                                <i class="bi bi-plus-circle"></i> Tambah Kegiatan
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="recent-card">
                    <h5>
                        <i class="bi bi-wallet2"></i> Iuran Bulanan Terbaru
                        <a href="/admin/monthly_dues.php" class="btn btn-sm" style="background-color: #6f42c1; color: white;">Lihat Semua</a>
                    </h5>
                    <?php if (count($recentMonthlyDues) > 0): ?>
                        <?php foreach ($recentMonthlyDues as $due): ?>
                            <div class="recent-item">
                                <h6><?php echo $due['name']; ?></h6>
                                <p><?php echo $due['description'] ?: 'Tidak ada keterangan'; ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small><?php echo date('d/m/Y', strtotime($due['date'])); ?></small>
                                    <span class="badge" style="background-color: #6f42c1;">
                                        Rp <?php echo number_format($due['amount'], 0, ',', '.'); ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center p-4">
                            <p class="text-muted">Belum ada data iuran bulanan</p>
                            <a href="/admin/add_monthly_due.php" class="btn btn-sm" style="background-color: #6f42c1; color: white;">
                                <i class="bi bi-plus-circle"></i> Tambah Iuran
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="recent-card">
                    <h5>
                        <i class="bi bi-megaphone"></i> Pengumuman Terbaru
                        <a href="/admin/announcements.php" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                    </h5>
                    <?php if (count($recentAnnouncements) > 0): ?>
                        <?php foreach ($recentAnnouncements as $announcement): ?>
                            <div class="recent-item">
                                <h6><?php echo $announcement['title']; ?></h6>
                                <p><?php echo substr($announcement['content'], 0, 100) . '...'; ?></p>
                                <small>
                                    <i class="bi bi-clock"></i> <?php echo date('d/m/Y H:i', strtotime($announcement['created_at'])); ?>
                                </small>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center p-4">
                            <p class="text-muted">Belum ada pengumuman</p>
                            <a href="/admin/add_announcement.php" class="btn btn-sm btn-warning">
                                <i class="bi bi-plus-circle"></i> Tambah Pengumuman
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>