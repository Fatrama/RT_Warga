<?php
require_once '../includes/header.php';
require_once '../includes/navbar.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

// Cek apakah user adalah admin
requireAdmin();

// Mengambil data warga
$residents = fetchAll("SELECT * FROM residents ORDER BY name ASC");

// Menampilkan pesan sukses atau error
if (isset($_GET['success']) && $_GET['success'] == 'deleted') {
    echo '<div class="alert alert-success">Data warga berhasil dihapus.</div>';
} elseif (isset($_GET['error']) && $_GET['error'] == 'delete_failed') {
    echo '<div class="alert alert-danger">Gagal menghapus data warga.</div>';
}
?>

<div class="container mt-4">
    <h1 class="mb-4">Manajemen Data Warga</h1>
    
    <div class="d-flex justify-content-between mb-3">
        <a href="add_resident.php" class="btn btn-primary">Tambah Warga</a>
        <a href="export.php?type=residents" class="btn btn-success">Export Data</a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <?php if (count($residents) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Tempat, Tanggal Lahir</th>
                                <th>Alamat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($residents as $resident): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $resident['nik']; ?></td>
                                    <td><?php echo $resident['name']; ?></td>
                                    <td><?php echo $resident['gender'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?></td>
                                    <td><?php echo $resident['birth_place'] . ', ' . formatDate($resident['birth_date']); ?></td>
                                    <td><?php echo $resident['address']; ?></td>
                                    <td>
                                        <?php if ($resident['status'] == 'permanent'): ?>
                                            <span class="badge bg-success">Tetap</span>
                                        <?php elseif ($resident['status'] == 'contract'): ?>
                                            <span class="badge bg-warning">Kontrak</span>
                                        <?php else: ?>
                                            <span class="badge bg-info">Pendatang</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="edit_resident.php?id=<?php echo $resident['id']; ?>" class="btn btn-sm btn-info">Edit</a>
                                        <a href="../process/delete_resident.php?id=<?php echo $resident['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">Belum ada data warga.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>