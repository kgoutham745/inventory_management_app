<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/config.php'; // Load constants
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Pekka' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    
    <!-- Optional custom CSS -->
    <!-- <link rel="stylesheet" href="../assets/css/style.css"> -->

    <link rel="manifest" href="../../manifest.json">
    <meta name="theme-color" content="#0d6efd">

    <!-- iOS PWA support -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Pekka">
    <link rel="apple-touch-icon" href="../../assets/icons/icon.png">

    <link rel="icon" type="image/png" sizes="32x32" href="../../assets/icons/icon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/icons/icon.png">

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-5">
        <div class="container">
            <a class="navbar-brand" href="">PEKKA</a>
            <div>
                <?php if (!empty($_SESSION['username'])): ?>
                    <span class="navbar-text text-light me-3">Welcome, <?= htmlspecialchars($_SESSION['username']) ?></span>
                    <a href="<?= LOGOUT_PAGE ?>" class="btn btn-outline-light btn-sm">Logout</a>
                <?php else: ?>
                    <a href="<?= LOGIN_PAGE ?>" class="btn btn-outline-light btn-sm">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
<div class="container mb-5">
