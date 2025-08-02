<?php
session_start();
// require 'db.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../config/config.php';

require_once __DIR__ . '/../auth/require.php';

requireRole('user');

$user_id = $_SESSION['user_id'];
$shop_id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM shops WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $shop_id, $user_id);
$stmt->execute();

header("Location: " . USER_HOME_PAGE);
