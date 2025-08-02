<?php
require_once __DIR__ . '/../../config/config.php';

session_start();
session_unset(); // Remove all session variables
session_destroy(); // Destroy the session
header("Location: " . LOGIN_PAGE);
exit();
