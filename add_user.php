<?php
require 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];
$role     = $_POST['role'];

$sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $password, $role);

if ($stmt->execute()) {
    header("Location: admin_dashboard.php");
} else {
    echo "Error adding user: " . $stmt->error;
}
?>
