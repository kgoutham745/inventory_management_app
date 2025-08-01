<?php
session_start();
require 'db.php';

if ($_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$shop_id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM shops WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $shop_id, $user_id);
$stmt->execute();

header("Location: user_dashboard.php");
