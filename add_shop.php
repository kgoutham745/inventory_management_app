<?php
session_start();
require 'db.php';

if ($_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$shop_name = $_POST['shop_name'];
$owner_name = $_POST['owner_name'];
$location = $_POST['location'];
$phone = $_POST['phone'];

$sql = "INSERT INTO shops (user_id, shop_name, owner_name, location, phone) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issss", $user_id, $shop_name, $owner_name, $location, $phone);

if ($stmt->execute()) {
    header("Location: user_dashboard.php");
} else {
    echo "Error adding shop: " . $stmt->error;
}
