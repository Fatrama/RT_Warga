<?php
require_once '../includes/functions.php';
require_once '../includes/auth.php';

// Cek apakah user adalah admin
requireAdmin();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        executeQuery("DELETE FROM finance WHERE id = ?", [$id]);
        header('Location: ../admin/finance.php?success=deleted');
    } catch (PDOException $e) {
        header('Location: ../admin/finance.php?error=delete_failed');
    }
} else {
    header('Location: ../admin/finance.php');
}
?>