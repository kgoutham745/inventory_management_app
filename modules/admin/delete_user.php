<?php
// require 'db.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../config/config.php';

$id = $_GET['id'];

$sql = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: " . ADMIN_HOME_PAGE);
} else {
    echo "Error deleting user.";
}
?>
