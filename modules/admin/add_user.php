<?php
// require 'db.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../config/config.php';

$username = $_POST['username'];
$password = $_POST['password'];
$role     = $_POST['role'];

$sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $password, $role);

if ($stmt->execute()) {
    header("Location: " . ADMIN_HOME_PAGE);
} else {
    echo "Error adding user: " . $stmt->error;
}
?>
