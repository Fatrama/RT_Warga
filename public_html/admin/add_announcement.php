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
    $content = $_POST['content'] ?? '';
    
    try {
        $stmt = $pdo->prepare("INSERT INTO announcements (title, content) VALUES (?, ?)");
        $stmt->execute([$title, $content]);
        
        // Redirect with success message
        header('Location: /admin/announcements.php?success=added');
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
    <title>Tambah Pengumuman - RT 01</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .form-header { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; }
        .editor { min-height: 200px; }
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
                        <a class="nav-link" href="/admin/announcements.php">
                            <i class="bi bi-megaphone"></i> Pengumuman
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
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header form-header">
                        <h4 class="mb-0"><i class="bi bi-megaphone"></i> Tambah Pengumuman</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form method="post">
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul Pengumuman <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" required 
                                       placeholder="Contoh: Libur Nasional, Pembayaran Iuran, dll.">
                            </div>
                            
                            <div class="mb-3">
                                <label for="content" class="form-label">Isi Pengumuman <span class="text-danger">*</span></label>
                                <textarea class="form-control editor" id="content" name="content" rows="8" required 
                                          placeholder="Tulis isi pengumuman secara lengkap dan jelas..."></textarea>
                                <div class="form-text">
                                    <i class="bi bi-info-circle"></i> 
                                    Pengumuman akan langsung muncul di halaman utama website
                                </div>
                            </div>
                            
                            <div class="alert alert-info">
                                <i class="bi bi-lightbulb"></i> <strong>Tips:</strong>
                                <ul class="mb-0">
                                    <li>Gunakan bahasa yang jelas dan mudah dipahami</li>
                                    <li>Sertakan informasi penting seperti tanggal, waktu, dan tempat jika relevan</li>
                                    <li>Periksa kembali sebelum mempublikasikan</li>
                                </ul>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="/admin/announcements.php" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-send"></i> Publikasikan Pengumuman
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