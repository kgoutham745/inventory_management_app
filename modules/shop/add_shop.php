<?php
session_start();
// require 'db.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../config/config.php';

require_once __DIR__ . '/../auth/require.php';

requireRole('user');

$user_id = $_SESSION['user_id'];
$shop_name = $_POST['shop_name'];
$owner_name = $_POST['owner_name'];
$location = $_POST['location'];
$phone = $_POST['phone'];

$sql = "INSERT INTO shops (user_id, shop_name, owner_name, location, phone) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issss", $user_id, $shop_name, $owner_name, $location, $phone);

if ($stmt->execute()) {
    header("Location: " . USER_HOME_PAGE);
} else {
    echo "Error adding shop: " . $stmt->error;
}
