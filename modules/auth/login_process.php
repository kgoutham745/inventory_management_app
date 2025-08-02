<?php
session_start();
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../config/config.php';

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();
if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if ($password === $user['password']) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: " . ADMIN_HOME_PAGE);
        } else {
            header("Location: " . USER_HOME_PAGE);
        }
        exit();
    } else {
        echo "Invalid password.";
    }
} else {
    echo "No user found.";
}

$conn->close();
?>
