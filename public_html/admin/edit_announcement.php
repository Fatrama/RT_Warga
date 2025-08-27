<?php
require_once '../includes/header.php';
require_once '../includes/navbar.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

// Cek apakah user adalah admin
requireAdmin();

// Mengambil data pengumuman berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $announcement = fetchOne("SELECT * FROM announcements WHERE id = ?", [$id]);
    
    if (!$announcement) {
        header('Location: announcements.php');
        exit;
    }
} else {
    header('Location: announcements.php');
    exit;
}
?>

<div class="container mt-4">
    <h1 class="mb-4">Edit Pengumuman</h1>
    
    <div class="card">
        <div class="card-body">
            <form action="../process/edit_announcement.php" method="post">
                <input type="hidden" name="id" value="<?php echo $announcement['id']; ?>">
                
                <div class="mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo $announcement['title']; ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="content" class="form-label">Isi Pengumuman</label>
                    <textarea class="form-control" id="content" name="content" rows="5" required><?php echo $announcement['content']; ?></textarea>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="announcements.php" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>