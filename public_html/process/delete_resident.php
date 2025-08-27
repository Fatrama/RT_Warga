<?php
require_once '../includes/functions.php';
require_once '../includes/auth.php';

// Cek apakah user adalah admin
requireAdmin();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        executeQuery("DELETE FROM residents WHERE id = ?", [$id]);
        header('Location: ../admin/residents.php?success=deleted');
    } catch (PDOException $e) {
        header('Location: ../admin/residents.php?error=delete_failed');
    }
} else {
    header('Location: ../admin/residents.php');
}
?>