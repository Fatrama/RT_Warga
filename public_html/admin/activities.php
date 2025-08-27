<?php
require_once '../includes/header.php';
require_once '../includes/navbar.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

// Cek apakah user adalah admin
requireAdmin();

// Mengambil data kegiatan
$activities = fetchAll("SELECT * FROM activities ORDER BY date DESC");

// Menampilkan pesan sukses atau error
if (isset($_GET['success']) && $_GET['success'] == 'deleted') {
    echo '<div class="alert alert-success">Kegiatan berhasil dihapus.</div>';
} elseif (isset($_GET['error']) && $_GET['error'] == 'delete_failed') {
    echo '<div class="alert alert-danger">Gagal menghapus kegiatan.</div>';
}
?>

<div class="container mt-4">
    <h1 class="mb-4">Manajemen Kegiatan</h1>
    
    <div class="d-flex justify-content-between mb-3">
        <a href="add_activity.php" class="btn btn-primary">Tambah Kegiatan</a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <?php if (count($activities) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Tanggal</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($activities as $activity): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $activity['title']; ?></td>
                                    <td><?php echo formatDate($activity['date']); ?></td>
                                    <td><?php echo $activity['location']; ?></td>
                                    <td>
                                        <?php if ($activity['status'] == 'upcoming'): ?>
                                            <span class="badge bg-info">Akan Datang</span>
                                        <?php elseif ($activity['status'] == 'ongoing'): ?>
                                            <span class="badge bg-warning">Sedang Berlangsung</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Selesai</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="edit_activity.php?id=<?php echo $activity['id']; ?>" class="btn btn-sm btn-info">Edit</a>
                                        <a href="../process/delete_activity.php?id=<?php echo $activity['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">Belum ada kegiatan.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>