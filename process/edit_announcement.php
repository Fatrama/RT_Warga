<?php
require_once '../includes/functions.php';
require_once '../includes/auth.php';

// Cek apakah user adalah admin
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = cleanInput($_POST['id']);
    $title = cleanInput($_POST['title']);
    $content = cleanInput($_POST['content']);

    // Query untuk mengupdate pengumuman
    $query = "UPDATE announcements SET title = ?, content = ? WHERE id = ?";
    
    try {
        executeQuery($query, [$title, $content, $id]);
        header('Location: ../admin/announcements.php?success=updated');
    } catch (PDOException $e) {
        header('Location: ../admin/edit_announcement.php?id=' . $id . '&error=failed');
    }
} else {
    header('Location: ../admin/announcements.php');
}
?>