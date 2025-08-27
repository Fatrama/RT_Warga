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
    } elseif ($type == 'monthly_dues') {
        // Export data iuran bulanan
        $filename = 'data_iuran_bulanan_' . date('Y-m-d') . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        
        $output = fopen('php://output', 'w');
        
        // Header CSV
        fputcsv($output, ['No', 'Tanggal', 'Nama Warga', 'Jenis', 'Keterangan', 'Jumlah']);
        
        // Data iuran bulanan
        $monthlyDues = $pdo->query("SELECT md.*, r.name as resident_name 
                                   FROM monthly_dues md 
                                   JOIN residents r ON md.resident_id = r.id 
                                   ORDER BY md.date DESC")->fetchAll();
        
        $no = 1;
        foreach ($monthlyDues as $due) {
            fputcsv($output, [
                $no++,
                $due['date'],
                $due['resident_name'],
                $due['type'],
                $due['description'] ?: '-',
                $due['amount']
            ]);
        }
        
        fclose($output);
        exit;
    }
} else {
    header('Location: /admin/dashboard.php');
}
?>