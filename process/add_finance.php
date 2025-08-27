<?php
require_once '../includes/functions.php';
require_once '../includes/auth.php';

// Cek apakah user adalah admin
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = cleanInput($_POST['date']);
    $description = cleanInput($_POST['description']);
    $type = cleanInput($_POST['type']);
    $amount = cleanInput($_POST['amount']);

    // Query untuk menambah data keuangan
    $query = "INSERT INTO finance (date, description, type, amount) VALUES (?, ?, ?, ?)";
    
    try {
        executeQuery($query, [$date, $description, $type, $amount]);
        header('Location: ../admin/finance.php?success=added');
    } catch (PDOException $e) {
        header('Location: ../admin/add_finance.php?error=failed');
    }
} else {
    header('Location: ../admin/finance.php');
}
?>