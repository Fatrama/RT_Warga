<?php
require_once '../includes/header.php';
require_once '../includes/auth.php';

// Jika sudah login, redirect ke halaman utama
if (isLoggedIn()) {
    header('Location: ../index.php');
    exit;
}
?>

<div class="login-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="login-form">
                    <div class="text-center mb-4">
                        <i class="bi bi-building" style="font-size: 4rem; color: #1e3c72;"></i>
                        <h4 class="mt-3">Login Admin RT 01</h4>
                    </div>
                    
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger">
                            <?php
                            if ($_GET['error'] == 'invalid') {
                                echo '<i class="bi bi-exclamation-triangle"></i> Username atau password salah!';
                            } elseif ($_GET['error'] == 'empty') {
                                echo '<i class="bi bi-exclamation-triangle"></i> Username dan password tidak boleh kosong!';
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                    
                    <form action="../process/login.php" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        
                        <button type="submit" class="btn btn-login w-100">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </button>
                        
                        <div class="text-center mt-3">
                            <small class="text-muted">Default: admin / password</small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>