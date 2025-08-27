<?php
require_once '../includes/header.php';
require_once '../includes/navbar.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

// Cek apakah user adalah admin
requireAdmin();

// Mengambil data keuangan berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $finance = fetchOne("SELECT * FROM finance WHERE id = ?", [$id]);
    
    if (!$finance) {
        header('Location: finance.php');
        exit;
    }
} else {
    header('Location: finance.php');
    exit;
}
?>

<div class="container mt-4">
    <h1 class="mb-4">Edit Transaksi Keuangan</h1>
    
    <div class="card">
        <div class="card-body">
            <form action="../process/edit_finance.php" method="post">
                <input type="hidden" name="id" value="<?php echo $finance['id']; ?>">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="date" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="date" name="date" value="<?php echo $finance['date']; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="type" class="form-label">Jenis</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="">Pilih</option>
                                <option value="income" <?php echo $finance['type'] == 'income' ? 'selected' : ''; ?>>Pemasukan</option>
                                <option value="expense" <?php echo $finance['type'] == 'expense' ? 'selected' : ''; ?>>Pengeluaran</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Keterangan</label>
                    <textarea class="form-control" id="description" name="description" rows="2" required><?php echo $finance['description']; ?></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="amount" class="form-label">Jumlah</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control" id="amount" name="amount" min="0" step="0.01" value="<?php echo $finance['amount']; ?>" required>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="finance.php" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>