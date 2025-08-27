<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session di awal
session_start();

echo "<h1>Debug Login Process</h1>";

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "<p>Form submitted via POST</p>";
    echo "<p>Username: " . $_POST['username'] . "</p>";
    echo "<p>Password: " . $_POST['password'] . "</p>";
    
    // Try to include files
    try {
        require_once __DIR__ . '/../includes/functions.php';
        echo "<p>functions.php included successfully</p>";
    } catch (Exception $e) {
        echo "<p>Error including functions.php: " . $e->getMessage() . "</p>";
    }
    
    try {
        require_once __DIR__ . '/../includes/auth.php';
        echo "<p>auth.php included successfully</p>";
    } catch (Exception $e) {
        echo "<p>Error including auth.php: " . $e->getMessage() . "</p>";
    }
    
    // Test database connection
    try {
        // Database connection is now included in functions.php
        echo "<p>Database connection successful</p>";
        
        // Test query
        $query = "SELECT * FROM users WHERE username = ?";
        $user = fetchOne($query, [$_POST['username']]);
        
        if ($user) {
            echo "<p>User found: " . $user['username'] . "</p>";
            
            // Test password verification
            if (password_verify($_POST['password'], $user['password'])) {
                echo "<p>Password verification successful!</p>";
                
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_role'] = $user['role'];
                
                echo "<p>Session variables set successfully</p>";
                echo "<p>Redirecting to dashboard...</p>";
                
                // Redirect based on role
                if ($user['role'] == 'admin') {
                    header('Location: /admin/dashboard.php');
                } else {
                    header('Location: /index.php');
                }
                exit;
            } else {
                echo "<p>Password verification failed!</p>";
            }
        } else {
            echo "<p>User not found!</p>";
        }
    } catch (Exception $e) {
        echo "<p>Database error: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>Form not submitted</p>";
}
?>