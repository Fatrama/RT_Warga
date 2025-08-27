<?php
require_once '../includes/header.php';
require_once '../includes/navbar.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';
requireAdmin();

$id = $_GET['id'];
$due = fetchOne("SELECT * FROM monthly_dues WHERE id = $id");
$residents = fetchAll("SELECT id, name FROM residents ORDER BY name ASC");
?>

<div class="container mt-4">
    <h2>Edit Iuran Bulanan</h2>
    <form action="../process/edit_monthly_due.php" method="post">
        <input type="hidden" name="id" value="<?php echo $due['id']; ?>">
        <div class="form-group">
            <label for="date">Tanggal</label>
            <input type="date" class="form-control" id="date" name="date" value="<?php echo $due['date']; ?>" required>
        </div>
        <div class="form-group">
            <label for="resident_id">Nama Warga</label>
            <select class="form-control" id="resident_id" name="resident_id" required>
                <?php foreach ($residents as $resident) { ?>
                    <option value="<?php echo $resident['id']; ?>" <?php echo ($resident['id'] == $due['resident_id']) ? 'selected' : ''; ?>>
                        <?php echo $resident['name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="type">Jenis</label>
            <input type="text" class="form-control" id="type" name="type" value="<?php echo $due['type']; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="description">Keterangan</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?php echo $due['description']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="amount">Nominal</label>
            <input type="number" class="form-control" id="amount" name="amount" step="0.01" value="<?php echo $due['amount']; ?>" required>
        </div>
        <button type="submit" class="btn btn-warning">Update</button>
        <a href="finance.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>