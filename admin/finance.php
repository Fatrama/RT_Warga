<?php
require_once '../includes/header.php';
require_once '../includes/navbar.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';
// Cek apakah user adalah admin
requireAdmin();

// Mengambil data keuangan
$finances = fetchAll("SELECT * FROM finance ORDER BY date DESC");

// Menghitung total pemasukan dan pengeluaran
$totalIncome = fetchOne("SELECT SUM(amount) as total FROM finance WHERE type = 'income'")['total'] ?? 0;
$totalExpense = fetchOne("SELECT SUM(amount) as total FROM finance WHERE type = 'expense'")['total'] ?? 0;
$balance = $totalIncome - $totalExpense;

// Mengambil data iuran bulanan
$monthlyDues = fetchAll("SELECT md.*, r.name as resident_name 
                        FROM monthly_dues md 
                        JOIN residents r ON md.resident_id = r.id 
                        ORDER BY md.date DESC");

// Menghitung total iuran bulanan
$totalMonthlyDues = fetchOne("SELECT SUM(amount) as total FROM monthly_dues")['total'] ?? 0;

// Menampilkan pesan sukses atau error
if (isset($_GET['success']) && $_GET['success'] == 'deleted') {
    echo '<div class="alert alert-success">Data keuangan berhasil dihapus.</div>';
} elseif (isset($_GET['error']) && $_GET['error'] == 'delete_failed') {
    echo '<div class="alert alert-danger">Gagal menghapus data keuangan.</div>';
} elseif (isset($_GET['status']) && $_GET['status'] == 'success') {
    echo '<div class="alert alert-success">Data iuran berhasil disimpan!</div>';
} elseif (isset($_GET['status']) && $_GET['status'] == 'deleted') {
    echo '<div class="alert alert-success">Data iuran berhasil dihapus!</div>';
}
?>
<div class="container mt-4">
    <h1 class="mb-4">Manajemen Keuangan</h1>
    
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Pemasukan</h5>
                    <h3><?php echo formatCurrency($totalIncome); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Pengeluaran</h5>
                    <h3><?php echo formatCurrency($totalExpense); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Saldo</h5>
                    <h3><?php echo formatCurrency($balance); ?></h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="d-flex justify-content-between mb-3">
        <a href="add_finance.php" class="btn btn-primary">Tambah Transaksi</a>
        <a href="export.php?type=finance" class="btn btn-success">Export Data</a>
    </div>
    
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Data Transaksi Keuangan</h5>
        </div>
        <div class="card-body">
            <?php if (count($finances) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Jenis</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($finances as $finance): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo formatDate($finance['date']); ?></td>
                                    <td><?php echo $finance['description']; ?></td>
                                    <td>
                                        <?php if ($finance['type'] == 'income'): ?>
                                            <span class="badge bg-success">Pemasukan</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Pengeluaran</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo formatCurrency($finance['amount']); ?></td>
                                    <td>
                                        <a href="edit_finance.php?id=<?php echo $finance['id']; ?>" class="btn btn-sm btn-info">Edit</a>
                                        <a href="../process/delete_finance.php?id=<?php echo $finance['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">Belum ada data keuangan.</div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Bagian Iuran Bulanan -->
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
        <a href="export.php?type=monthly_dues" class="btn btn-success">Export Iuran</a>
    </div>
    
    <div class="card">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0">Data Iuran Bulanan</h5>
        </div>
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