<?php
require_once '../includes/header.php';
require_once '../includes/navbar.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';
requireAdmin();

// Mengambil data iuran bulanan
$monthlyDues = fetchAll("SELECT md.*, r.name as resident_name 
                        FROM monthly_dues md 
                        JOIN residents r ON md.resident_id = r.id 
                        ORDER BY md.date DESC");

// Menghitung total iuran bulanan
$totalMonthlyDues = fetchOne("SELECT SUM(amount) as total FROM monthly_dues")['total'] ?? 0;

// Menampilkan pesan sukses atau error
if (isset($_GET['status']) && $_GET['status'] == 'success') {
    echo '<div class="alert alert-success">Data iuran berhasil disimpan!</div>';
} elseif (isset($_GET['status']) && $_GET['status'] == 'deleted') {
    echo '<div class="alert alert-success">Data iuran berhasil dihapus!</div>';
}
?>
<div class="container mt-4">
    <h1 class="mb-4">Manajemen Iuran Bulanan</h1>
    
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Iuran Bulanan</h5>
                    <h3><?php echo formatCurrency($totalMonthlyDues); ?></h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="d-flex justify-content-between mb-3">
        <a href="add_monthly_due.php" class="btn btn-warning">Tambah Iuran Bulanan</a>
        <a href="export.php?type=monthly_dues" class="btn btn-success">Export Data</a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <?php if (count($monthlyDues) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama Warga</th>
                                <th>Jenis</th>
                                <th>Keterangan</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($monthlyDues as $due): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo formatDate($due['date']); ?></td>
                                    <td><?php echo $due['resident_name']; ?></td>
                                    <td>
                                        <span class="badge bg-warning"><?php echo $due['type']; ?></span>
                                    </td>
                                    <td><?php echo $due['description']; ?></td>
                                    <td><?php echo formatCurrency($due['amount']); ?></td>
                                    <td>
                                        <a href="edit_monthly_due.php?id=<?php echo $due['id']; ?>" class="btn btn-sm btn-info">Edit</a>
                                        <a href="../process/delete_monthly_due.php?id=<?php echo $due['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">Belum ada data iuran bulanan.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>