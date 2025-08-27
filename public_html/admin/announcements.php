<?php
require_once '../includes/header.php';
require_once '../includes/navbar.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

// Cek apakah user adalah admin
requireAdmin();

// Mengambil data pengumuman
$announcements = fetchAll("SELECT * FROM announcements ORDER BY created_at DESC");

// Menampilkan pesan sukses atau error
if (isset($_GET['success']) && $_GET['success'] == 'deleted') {
    echo '<div class="alert alert-success">Pengumuman berhasil dihapus.</div>';
} elseif (isset($_GET['error']) && $_GET['error'] == 'delete_failed') {
    echo '<div class="alert alert-danger">Gagal menghapus pengumuman.</div>';
}
?>

<div class="container mt-4">
    <h1 class="mb-4">Manajemen Pengumuman</h1>
    
    <div class="d-flex justify-content-between mb-3">
        <a href="add_announcement.php" class="btn btn-primary">Tambah Pengumuman</a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <?php if (count($announcements) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($announcements as $announcement): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $announcement['title']; ?></td>
                                    <td><?php echo formatDate($announcement['created_at']); ?></td>
                                    <td>
                                        <a href="edit_announcement.php?id=<?php echo $announcement['id']; ?>" class="btn btn-sm btn-info">Edit</a>
                                        <a href="../process/delete_announcement.php?id=<?php echo $announcement['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">Belum ada pengumuman.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>