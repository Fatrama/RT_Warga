<?php
session_start();

echo "<h1>Simple Login Process</h1>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "<p>Form submitted via POST</p>";
    echo "<p>Username: " . $_POST['username'] . "</p>";
    echo "<p>Password: " . $_POST['password'] . "</p>";
    
    // Koneksi database langsung
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=rt_database", "rt_user", "password_anda");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "<p>Database connection successful</p>";
        
        // Query user
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$_POST['username']]);
        $user = $stmt->fetch();
        
        if ($user) {
            echo "<p>User found: " . $user['username'] . "</p>";
            
            // Verifikasi password
            if (password_verify($_POST['password'], $user['password'])) {
                echo "<p>Password verification successful!</p>";
                
                // Set session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_role'] = $user['role'];
                
                echo "<p>Session variables set</p>";
                echo "<p>Redirecting to dashboard...</p>";
                
                // Redirect
                header('Location: /admin/dashboard.php');
                exit;
            } else {
                echo "<p>Password verification failed!</p>";
                echo "<p>Expected hash: " . $user['password'] . "</p>";
                echo "<p>Input password: " . $_POST['password'] . "</p>";
            }
        } else {
            echo "<p>User not found!</p>";
        }
    } catch (PDOException $e) {
        echo "<p>Database error: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>Form not submitted</p>";
}
?>