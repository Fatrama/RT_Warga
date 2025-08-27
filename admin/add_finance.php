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
    $date = $_POST['date'] ?? '';
    $description = $_POST['description'] ?? '';
    $type = $_POST['type'] ?? '';
    $amount = $_POST['amount'] ?? '';
    
    try {
        $stmt = $pdo->prepare("INSERT INTO finance (date, description, type, amount) VALUES (?, ?, ?, ?)");
        $stmt->execute([$date, $description, $type, $amount]);
        
        // Redirect with success message
        header('Location: /admin/finance.php?success=added');
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
    <title>Tambah Transaksi Keuangan - RT 01</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .form-header { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; }
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
                        <a class="nav-link" href="/admin/finance.php">
                            <i class="bi bi-cash-stack"></i> Keuangan
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
                        <h4 class="mb-0"><i class="bi bi-cash-coin"></i> Tambah Transaksi Keuangan</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Tanggal Transaksi <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="date" name="date" required value="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="type" class="form-label">Jenis Transaksi <span class="text-danger">*</span></label>
                                        <select class="form-select" id="type" name="type" required>
                                            <option value="">Pilih Jenis</option>
                                            <option value="income">Pemasukan</option>
                                            <option value="expense">Pengeluaran</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Keterangan <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="2" required 
                                          placeholder="Contoh: Iuran bulan Januari, Pembelian alat kebersihan, dll."></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="amount" class="form-label">Jumlah <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="amount" name="amount" required 
                                           min="0" step="100" placeholder="0">
                                </div>
                                <div class="form-text">Masukkan jumlah dalam Rupiah tanpa titik atau koma</div>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="/admin/finance.php" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-save"></i> Simpan Transaksi
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