<?php
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header('Location: /pages/login.php');
    exit;
}

require_once __DIR__ . '/../config/database.php';

if (isset($_GET['type'])) {
    $type = $_GET['type'];
    
    if ($type == 'residents') {
        // Export data warga
        $filename = 'data_warga_' . date('Y-m-d') . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        
        $output = fopen('php://output', 'w');
        
        // Header CSV
        fputcsv($output, ['NIK', 'Nama', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Alamat', 'No. Telepon', 'Pekerjaan', 'Status']);
        
        // Data warga
        $residents = $pdo->query("SELECT * FROM residents ORDER BY name ASC")->fetchAll();
        foreach ($residents as $resident) {
            fputcsv($output, [
                $resident['nik'],
                $resident['name'],
                $resident['gender'] == 'L' ? 'Laki-laki' : 'Perempuan',
                $resident['birth_place'],
                $resident['birth_date'],
                $resident['address'],
                $resident['phone'],
                $resident['occupation'],
                $resident['status'] == 'permanent' ? 'Tetap' : ($resident['status'] == 'contract' ? 'Kontrak' : 'Pendatang')
            ]);
        }
        
        fclose($output);
        exit;
    } elseif ($type == 'finance') {
        // Export data keuangan
        $filename = 'data_keuangan_' . date('Y-m-d') . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        
        $output = fopen('php://output', 'w');
        
        // Header CSV
        fputcsv($output, ['Tanggal', 'Keterangan', 'Jenis', 'Jumlah']);
        
        // Data keuangan
        $finances = $pdo->query("SELECT * FROM finance ORDER BY date DESC")->fetchAll();
        foreach ($finances as $finance) {
            fputcsv($output, [
                $finance['date'],
                $finance['description'],
                $finance['type'] == 'income' ? 'Pemasukan' : 'Pengeluaran',
                $finance['amount']
            ]);
        }
        
        fclose($output);
        exit;
    }
} else {
    header('Location: /admin/dashboard.php');
}
?>