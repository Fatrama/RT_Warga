<?php
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header('Location: /pages/login.php');
    exit;
}

require_once __DIR__ . '/../config/database.php';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'] ?? '';
    $date = $_POST['date'] ?? '';
    $location = $_POST['location'] ?? '';
    $description = $_POST['description'] ?? '';
    $status = $_POST['status'] ?? '';
    
    try {
        $stmt = $pdo->prepare("INSERT INTO activities (title, date, location, description, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $date, $location, $description, $status]);
        
        // Redirect with success message
        header('Location: /admin/activities.php?success=added');
        exit;
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kegiatan - RT 01</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .form-header { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/index.php">
                <i class="bi bi-building"></i> RT 01
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/dashboard.php">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/activities.php">
                            <i class="bi bi-calendar-event"></i> Kegiatan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/process/logout.php">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header form-header">
                        <h4 class="mb-0"><i class="bi bi-calendar-plus"></i> Tambah Kegiatan</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form method="post">
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul Kegiatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" required 
                                       placeholder="Contoh: Gotong Royong Bersih-bersih Lingkungan">
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Tanggal Kegiatan <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="date" name="date" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="location" class="form-label">Lokasi <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="location" name="location" required 
                                               placeholder="Contoh: Halaman RT, Balai RW, dll.">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi Kegiatan</label>
                                <textarea class="form-control" id="description" name="description" rows="4" 
                                          placeholder="Jelaskan secara detail mengenai kegiatan yang akan dilakukan..."></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="status" class="form-label">Status Kegiatan <span class="text-danger">*</span></label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="upcoming">Akan Datang</option>
                                    <option value="ongoing">Sedang Berlangsung</option>
                                    <option value="completed">Selesai</option>
                                </select>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="/admin/activities.php" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-info">
                                    <i class="bi bi-save"></i> Simpan Kegiatan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>