<?php
require_once '../includes/functions.php';
require_once '../includes/auth.php';

// Cek apakah user adalah admin
requireAdmin();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        executeQuery("DELETE FROM activities WHERE id = ?", [$id]);
        header('Location: ../admin/activities.php?success=deleted');
    } catch (PDOException $e) {
        header('Location: ../admin/activities.php?error=delete_failed');
    }
} else {
    header('Location: ../admin/activities.php');
}
?>