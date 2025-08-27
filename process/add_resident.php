<?php
require_once '../includes/functions.php';
require_once '../includes/auth.php';

// Cek apakah user adalah admin
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nik = cleanInput($_POST['nik']);
    $name = cleanInput($_POST['name']);
    $gender = cleanInput($_POST['gender']);
    $birth_place = cleanInput($_POST['birth_place']);
    $birth_date = cleanInput($_POST['birth_date']);
    $address = cleanInput($_POST['address']);
    $phone = cleanInput($_POST['phone']);
    $occupation = cleanInput($_POST['occupation']);
    $status = cleanInput($_POST['status']);

    // Query untuk menambah data warga
    $query = "INSERT INTO residents (nik, name, gender, birth_place, birth_date, address, phone, occupation, status) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    try {
        executeQuery($query, [$nik, $name, $gender, $birth_place, $birth_date, $address, $phone, $occupation, $status]);
        header('Location: ../admin/residents.php?success=added');
    } catch (PDOException $e) {
        // Jika terjadi error, kemungkinan karena NIK sudah ada
        header('Location: ../admin/add_resident.php?error=duplicate');
    }
} else {
    header('Location: ../admin/residents.php');
}
?>