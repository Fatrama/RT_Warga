<?php
require_once '../includes/functions.php';

if (isset($_GET['id'])) {
    $id = sanitize($_GET['id']);
    
    if (execute("DELETE FROM monthly_dues WHERE id = $id")) {
        header('Location: ../admin/finance.php?status=deleted');
    } else {
        header('Location: ../admin/finance.php?status=error');
    }
} else {
    header('Location: ../admin/finance.php');
}
?>