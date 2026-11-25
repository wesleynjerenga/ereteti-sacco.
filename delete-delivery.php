<?php
require_once 'includes/db.php';

$date = $_POST['date'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) ($_POST['delivery_id'] ?? 0);
    $stmt = mysqli_prepare($conn, 'DELETE FROM milk_delivery WHERE delivery_id = ?');
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
}
header('Location: deliveries.php?date=' . urlencode($date) . '&deleted=1');
exit;
