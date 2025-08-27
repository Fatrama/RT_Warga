<?php
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = sanitize($_POST['date']);
    $resident_id = sanitize($_POST['resident_id']);
    $type = sanitize($_POST['type']);
    $description = sanitize($_POST['description']);
    $amount = sanitize($_POST['amount']);

    $query = "INSERT INTO monthly_dues (date, resident_id, type, description, amount) 
              VALUES ('$date', '$resident_id', '$type', '$description', '$amount')";

    if (execute($query)) {
        header('Location: ../admin/finance.php?status=success');
    } else {
        header('Location: ../admin/finance.php?status=error');
    }
} else {
    header('Location: ../admin/finance.php');
}
?>