<?php
require_once '../includes/header.php';
require_once '../includes/navbar.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

// Cek apakah user adalah admin
requireAdmin();

// Mengambil data warga berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $resident = fetchOne("SELECT * FROM residents WHERE id = ?", [$id]);
    
    if (!$resident) {
        header('Location: residents.php');
        exit;
    }
} else {
    header('Location: residents.php');
    exit;
}
?>

<div class="container mt-4">
    <h1 class="mb-4">Edit Data Warga</h1>
    
    <div class="card">
        <div class="card-body">
            <form action="../process/edit_resident.php" method="post">
                <input type="hidden" name="id" value="<?php echo $resident['id']; ?>">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik" value="<?php echo $resident['nik']; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $resident['name']; ?>" required>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="gender" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="">Pilih</option>
                                <option value="L" <?php echo $resident['gender'] == 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                                <option value="P" <?php echo $resident['gender'] == 'P' ? 'selected' : ''; ?>>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="birth_place" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" id="birth_place" name="birth_place" value="<?php echo $resident['birth_place']; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="birth_date" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="birth_date" name="birth_date" value="<?php echo $resident['birth_date']; ?>" required>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea class="form-control" id="address" name="address" rows="2" required><?php echo $resident['address']; ?></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone" class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $resident['phone']; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="occupation" class="form-label">Pekerjaan</label>
                            <input type="text" class="form-control" id="occupation" name="occupation" value="<?php echo $resident['occupation']; ?>">
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="">Pilih</option>
                        <option value="permanent" <?php echo $resident['status'] == 'permanent' ? 'selected' : ''; ?>>Tetap</option>
                        <option value="contract" <?php echo $resident['status'] == 'contract' ? 'selected' : ''; ?>>Kontrak</option>
                        <option value="new" <?php echo $resident['status'] == 'new' ? 'selected' : ''; ?>>Pendatang</option>
                    </select>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="residents.php" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>