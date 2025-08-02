<?php

// Fetch all users
function getAllUsers($conn) {
    $stmt = $conn->prepare("SELECT * FROM users");
    $stmt->execute();
    return $stmt->get_result();
}

// Fetch all orders
function getAllOrders($conn) {
    $stmt = $conn->prepare("
        SELECT o.id AS order_id, o.quantity_boxes, o.status, o.created_at,
            s.shop_name, s.owner_name, u.username
            FROM orders o
            JOIN shops s ON o.shop_id = s.id
            JOIN users u ON s.user_id = u.id
            ORDER BY o.created_at DESC
    ");
    $stmt->execute();
    return $stmt->get_result();
}

// Fetch all shops with user info
function getAllShops($conn) {
    $stmt = $conn->prepare("
        SELECT s.*, u.username
        FROM shops s
        JOIN users u ON s.user_id = u.id
        ORDER BY s.created_at DESC
    ");
    $stmt->execute();
    return $stmt->get_result();
}
