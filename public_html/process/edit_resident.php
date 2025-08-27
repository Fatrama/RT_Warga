<?php
require_once '../includes/functions.php';
require_once '../includes/auth.php';

// Cek apakah user adalah admin
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = cleanInput($_POST['id']);
    $nik = cleanInput($_POST['nik']);
    $name = cleanInput($_POST['name']);
    $gender = cleanInput($_POST['gender']);
    $birth_place = cleanInput($_POST['birth_place']);
    $birth_date = cleanInput($_POST['birth_date']);
    $address = cleanInput($_POST['address']);
    $phone = cleanInput($_POST['phone']);
    $occupation = cleanInput($_POST['occupation']);
    $status = cleanInput($_POST['status']);

    // Query untuk mengupdate data warga
    $query = "UPDATE residents SET 
              nik = ?, name = ?, gender = ?, birth_place = ?, birth_date = ?, 
              address = ?, phone = ?, occupation = ?, status = ? 
              WHERE id = ?";
    
    try {
        executeQuery($query, [$nik, $name, $gender, $birth_place, $birth_date, $address, $phone, $occupation, $status, $id]);
        header('Location: ../admin/residents.php?success=updated');
    } catch (PDOException $e) {
        // Jika terjadi error, kemungkinan karena NIK sudah ada (kecuali NIKnya sama dengan yang lama)
        header('Location: ../admin/edit_resident.php?id=' . $id . '&error=duplicate');
    }
} else {
    header('Location: ../admin/residents.php');
}
?>