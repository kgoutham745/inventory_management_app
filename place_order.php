<?php
session_start();
require 'db.php';

if ($_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$shop_id = $_GET['shop_id'] ?? null;

// Verify shop belongs to user
$stmt = $conn->prepare("SELECT * FROM shops WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $shop_id, $user_id);
$stmt->execute();
$shop = $stmt->get_result()->fetch_assoc();

if (!$shop) {
    echo "Shop not found or unauthorized.";
    exit();
}

// Handle order submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantity = (int)$_POST['quantity'];

    $stmt = $conn->prepare("INSERT INTO orders (shop_id, quantity_boxes) VALUES (?, ?)");
    $stmt->bind_param("ii", $shop_id, $quantity);

    if ($stmt->execute()) {
        header("Location: user_dashboard.php");
        exit();
    } else {
        echo "Error placing order.";
    }
}
?>

<h2>Place Order for <?= htmlspecialchars($shop['shop_name']) ?></h2>
<form method="post">
    <label>Quantity (in boxes):</label><br>
    <input type="number" name="quantity" min="1" required><br><br>
    <button type="submit">Submit Order</button>
</form>
<a href="user_dashboard.php">Back</a>
