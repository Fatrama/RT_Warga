<?php
require_once '../includes/header.php';
require_once '../includes/navbar.php';
require_once '../includes/functions.php';

// Mengambil data warga
$residents = fetchAll("SELECT * FROM residents ORDER BY name ASC");
?>

<div class="container mt-4">
    <h1 class="mb-4">Data Warga</h1>
    
    <?php if (count($residents) > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Alamat</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($residents as $resident): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $resident['name']; ?></td>
                            <td><?php echo $resident['gender'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?></td>
                            <td><?php echo $resident['address']; ?></td>
                            <td>
                                <?php if ($resident['status'] == 'permanent'): ?>
                                    <span class="badge bg-success">Tetap</span>
                                <?php elseif ($resident['status'] == 'contract'): ?>
                                    <span class="badge bg-warning">Kontrak</span>
                                <?php else: ?>
                                    <span class="badge bg-info">Pendatang</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Belum ada data warga.</div>
    <?php endif; ?>
</div>

<?php require_once '../includes/footer.php'; ?>