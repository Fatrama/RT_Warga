<?php
require_once '../includes/header.php';
require_once '../includes/navbar.php';
require_once '../includes/functions.php';

// Mengambil data kegiatan
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $activity = fetchOne("SELECT * FROM activities WHERE id = ?", [$id]);
    
    if (!$activity) {
        header('Location: activities.php');
        exit;
    }
    
    // Tampilkan detail kegiatan
    ?>
    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../index.php">Beranda</a></li>
                <li class="breadcrumb-item"><a href="activities.php">Kegiatan</a></li>
                <li class="breadcrumb-item active"><?php echo $activity['title']; ?></li>
            </ol>
        </nav>
        
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0"><?php echo $activity['title']; ?></h2>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Tanggal:</strong> <?php echo formatDate($activity['date']); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Lokasi:</strong> <?php echo $activity['location']; ?></p>
                    </div>
                </div>
                
                <div class="mb-3">
                    <p><strong>Status:</strong> 
                        <?php if ($activity['status'] == 'upcoming'): ?>
                            <span class="badge bg-info">Akan Datang</span>
                        <?php elseif ($activity['status'] == 'ongoing'): ?>
                            <span class="badge bg-warning">Sedang Berlangsung</span>
                        <?php else: ?>
                            <span class="badge bg-success">Selesai</span>
                        <?php endif; ?>
                    </p>
                </div>
                
                <div class="mb-3">
                    <h5>Deskripsi:</h5>
                    <p><?php echo nl2br($activity['description']); ?></p>
                </div>
                
                <a href="activities.php" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
    <?php
} else {
    // Tampilkan daftar kegiatan
    $activities = fetchAll("SELECT * FROM activities ORDER BY date DESC");
    ?>
    <div class="container mt-4">
        <h1 class="mb-4">Kegiatan RT</h1>
        
        <?php if (count($activities) > 0): ?>
            <div class="row">
                <?php foreach ($activities as $activity): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $activity['title']; ?></h5>
                                <p class="card-text">
                                    <small class="text-muted"><?php echo formatDate($activity['date']); ?></small><br>
                                    <small><?php echo $activity['location']; ?></small>
                                </p>
                                <p class="card-text"><?php echo substr($activity['description'], 0, 100) . '...'; ?></p>
                                <a href="activities.php?id=<?php echo $activity['id']; ?>" class="btn btn-sm btn-primary">Detail</a>
                            </div>
                            <div class="card-footer">
                                <?php if ($activity['status'] == 'upcoming'): ?>
                                    <span class="badge bg-info">Akan Datang</span>
                                <?php elseif ($activity['status'] == 'ongoing'): ?>
                                    <span class="badge bg-warning">Sedang Berlangsung</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Selesai</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">Belum ada kegiatan.</div>
        <?php endif; ?>
    </div>
    <?php
}
?>

<?php require_once '../includes/footer.php'; ?>