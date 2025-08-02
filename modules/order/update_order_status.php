<?php
session_start();
// require 'db.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../config/config.php';

require_once __DIR__ . '/../auth/require.php';

requireRole('admin');

$order_id = $_POST['order_id'];
$status = $_POST['status'];

// Validate status
$valid_statuses = ['Approved', 'Rejected', 'Fulfilled'];
if (!in_array($status, $valid_statuses)) {
    die("Invalid status.");
}

$stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $order_id);

if ($stmt->execute()) {
    header("Location: " . ADMIN_HOME_PAGE);
} else {
    echo "Failed to update order.";
}
