<?php
session_start();
require 'db.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

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
    header("Location: admin_dashboard.php");
} else {
    echo "Failed to update order.";
}
