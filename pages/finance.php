<?php
require_once '../includes/header.php';
require_once '../includes/navbar.php';
require_once '../includes/functions.php';

// Menghitung total pemasukan dan pengeluaran
$totalIncome = fetchOne("SELECT SUM(amount) as total FROM finance WHERE type = 'income'")['total'] ?? 0;
$totalExpense = fetchOne("SELECT SUM(amount) as total FROM finance WHERE type = 'expense'")['total'] ?? 0;
$balance = $totalIncome - $totalExpense;

// Mengambil data keuangan
$finances = fetchAll("SELECT * FROM finance ORDER BY date DESC LIMIT 10");
?>

<div class="container mt-4">
    <h1 class="mb-4">Keuangan RT</h1>
    
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
    
    <h4 class="mb-3">Transaksi Terbaru</h4>
    
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
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Belum ada data keuangan.</div>
    <?php endif; ?>
</div>

<?php require_once '../includes/footer.php'; ?>