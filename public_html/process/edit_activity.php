<?php
require_once '../includes/functions.php';
require_once '../includes/auth.php';

// Cek apakah user adalah admin
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = cleanInput($_POST['id']);
    $title = cleanInput($_POST['title']);
    $date = cleanInput($_POST['date']);
    $location = cleanInput($_POST['location']);
    $description = cleanInput($_POST['description']);
    $status = cleanInput($_POST['status']);

    // Query untuk mengupdate kegiatan
    $query = "UPDATE activities SET title = ?, date = ?, location = ?, description = ?, status = ? WHERE id = ?";
    
    try {
        executeQuery($query, [$title, $date, $location, $description, $status, $id]);
        header('Location: ../admin/activities.php?success=updated');
    } catch (PDOException $e) {
        header('Location: ../admin/edit_activity.php?id=' . $id . '&error=failed');
    }
} else {
    header('Location: ../admin/activities.php');
}
?>