<?php
require_once '../includes/header.php';
require_once '../includes/navbar.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

// Cek apakah user adalah admin
requireAdmin();

// Mengambil data kegiatan berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $activity = fetchOne("SELECT * FROM activities WHERE id = ?", [$id]);
    
    if (!$activity) {
        header('Location: activities.php');
        exit;
    }
} else {
    header('Location: activities.php');
    exit;
}
?>

<div class="container mt-4">
    <h1 class="mb-4">Edit Kegiatan</h1>
    
    <div class="card">
        <div class="card-body">
            <form action="../process/edit_activity.php" method="post">
                <input type="hidden" name="id" value="<?php echo $activity['id']; ?>">
                
                <div class="mb-3">
                    <label for="title" class="form-label">Judul Kegiatan</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo $activity['title']; ?>" required>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="date" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="date" name="date" value="<?php echo $activity['date']; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="location" class="form-label">Lokasi</label>
                            <input type="text" class="form-control" id="location" name="location" value="<?php echo $activity['location']; ?>" required>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?php echo $activity['description']; ?></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="">Pilih</option>
                        <option value="upcoming" <?php echo $activity['status'] == 'upcoming' ? 'selected' : ''; ?>>Akan Datang</option>
                        <option value="ongoing" <?php echo $activity['status'] == 'ongoing' ? 'selected' : ''; ?>>Sedang Berlangsung</option>
                        <option value="completed" <?php echo $activity['status'] == 'completed' ? 'selected' : ''; ?>>Selesai</option>
                    </select>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="activities.php" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>