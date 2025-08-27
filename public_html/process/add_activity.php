<?php
require_once '../includes/functions.php';
require_once '../includes/auth.php';

// Cek apakah user adalah admin
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = cleanInput($_POST['title']);
    $date = cleanInput($_POST['date']);
    $location = cleanInput($_POST['location']);
    $description = cleanInput($_POST['description']);
    $status = cleanInput($_POST['status']);

    // Query untuk menambah kegiatan
    $query = "INSERT INTO activities (title, date, location, description, status) VALUES (?, ?, ?, ?, ?)";
    
    try {
        executeQuery($query, [$title, $date, $location, $description, $status]);
        header('Location: ../admin/activities.php?success=added');
    } catch (PDOException $e) {
        header('Location: ../admin/add_activity.php?error=failed');
    }
} else {
    header('Location: ../admin/activities.php');
}
?>