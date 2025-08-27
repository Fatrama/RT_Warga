<?php
require_once '../includes/functions.php';
require_once '../includes/auth.php';

// Cek apakah user adalah admin
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = cleanInput($_POST['id']);
    $date = cleanInput($_POST['date']);
    $description = cleanInput($_POST['description']);
    $type = cleanInput($_POST['type']);
    $amount = cleanInput($_POST['amount']);

    // Query untuk mengupdate data keuangan
    $query = "UPDATE finance SET date = ?, description = ?, type = ?, amount = ? WHERE id = ?";
    
    try {
        executeQuery($query, [$date, $description, $type, $amount, $id]);
        header('Location: ../admin/finance.php?success=updated');
    } catch (PDOException $e) {
        header('Location: ../admin/edit_finance.php?id=' . $id . '&error=failed');
    }
} else {
    header('Location: ../admin/finance.php');
}
?>