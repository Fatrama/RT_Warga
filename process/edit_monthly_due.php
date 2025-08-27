<?php
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = sanitize($_POST['id']);
    $date = sanitize($_POST['date']);
    $resident_id = sanitize($_POST['resident_id']);
    $description = sanitize($_POST['description']);
    $amount = sanitize($_POST['amount']);

    $query = "UPDATE monthly_dues SET 
              date = '$date',
              resident_id = '$resident_id',
              description = '$description',
              amount = '$amount'
              WHERE id = $id";

    if (execute($query)) {
        header('Location: ../admin/finance.php?status=success');
    } else {
        header('Location: ../admin/finance.php?status=error');
    }
} else {
    header('Location: ../admin/finance.php');
}
?>