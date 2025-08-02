<?php
// auth.php — Common authentication and role-check functions
require_once __DIR__ . '/../../config/config.php';

function requireRole($role) {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role) {
        header("Location: " . LOGIN_PAGE);
        exit();
    }
}

function requireLogin() {
    if (!isset($_SESSION['username'])) {
        header("Location: " . LOGIN_PAGE);
        exit();
    }
}
