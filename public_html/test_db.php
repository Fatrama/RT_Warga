<?php
require_once 'config/database.php';

echo "<h1>Database Connection Test</h1>";

try {
    $stmt = $pdo->query("SELECT * FROM users WHERE username = 'admin'");
    $user = $stmt->fetch();
    
    if ($user) {
        echo "<p>User found: " . $user['username'] . "</p>";
        echo "<p>Role: " . $user['role'] . "</p>";
        echo "<p>Password hash: " . $user['password'] . "</p>";
        
        // Test password verification
        $testPassword = 'password';
        if (password_verify($testPassword, $user['password'])) {
            echo "<p>Password verification successful!</p>";
        } else {
            echo "<p>Password verification failed!</p>";
        }
    } else {
        echo "<p>User not found!</p>";
    }
} catch (PDOException $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
?>