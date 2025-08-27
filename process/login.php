<?php
session_start();

// Include required files dengan path yang benar
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        header('Location: /pages/login.php?error=empty');
        exit;
    }

    try {
        // Get user from database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // Verify password
        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] == 'admin') {
                header('Location: /admin/dashboard.php');
            } else {
                header('Location: /index.php');
            }
            exit;
        } else {
            // Invalid credentials
            header('Location: /pages/login.php?error=invalid');
            exit;
        }
    } catch (PDOException $e) {
        // Database error
        die("Database error: " . $e->getMessage());
    }
} else {
    // Not a POST request
    header('Location: /pages/login.php');
    exit;
}
?>