<?php
require_once '../includes/header.php';
require_once '../includes/navbar.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';
requireAdmin();

// Ambil data resident dari database
$residents = fetchAll("SELECT id, name FROM residents ORDER BY name ASC");
?>

<div class="container mt-4">
    <h2>Tambah Iuran Bulanan</h2>
    <form action="../process/add_monthly_due.php" method="post">
        <div class="form-group">
            <label for="date">Tanggal</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <div class="form-group">
            <label for="resident_id">Nama Warga</label>
            <select class="form-control" id="resident_id" name="resident_id" required>
                <option value="">Pilih Nama</option>
                <?php foreach ($residents as $resident) { ?>
                    <option value="<?php echo $resident['id']; ?>"><?php echo $resident['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="type">Jenis</label>
            <input type="text" class="form-control" id="type" name="type" value="Iuran Bulanan" readonly>
        </div>
        <div class="form-group">
            <label for="description">Keterangan</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="amount">Nominal</label>
            <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
        </div>
        <button type="submit" class="btn btn-warning">Simpan</button>
        <a href="finance.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>