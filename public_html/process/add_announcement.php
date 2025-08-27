<?php
require_once '../includes/functions.php';
require_once '../includes/auth.php';

// Cek apakah user adalah admin
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = cleanInput($_POST['title']);
    $content = cleanInput($_POST['content']);

    // Query untuk menambah pengumuman
    $query = "INSERT INTO announcements (title, content) VALUES (?, ?)";
    
    try {
        executeQuery($query, [$title, $content]);
        header('Location: ../admin/announcements.php?success=added');
    } catch (PDOException $e) {
        header('Location: ../admin/add_announcement.php?error=failed');
    }
} else {
    header('Location: ../admin/announcements.php');
}
?>