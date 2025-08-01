<?php
session_start();
require 'db.php';

if ($_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$shop_id = $_GET['id'] ?? null;

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $shop_name = $_POST['shop_name'];
    $owner_name = $_POST['owner_name'];
    $location = $_POST['location'];
    $phone = $_POST['phone'];

    $sql = "UPDATE shops SET shop_name=?, owner_name=?, location=?, phone=? WHERE id=? AND user_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $shop_name, $owner_name, $location, $phone, $shop_id, $user_id);

    if ($stmt->execute()) {
        header("Location: user_dashboard.php");
    } else {
        echo "Error updating shop.";
    }
    exit();
}

// Fetch shop
$stmt = $conn->prepare("SELECT * FROM shops WHERE id=? AND user_id=?");
$stmt->bind_param("ii", $shop_id, $user_id);
$stmt->execute();
$shop = $stmt->get_result()->fetch_assoc();

if (!$shop) {
    echo "Shop not found.";
    exit();
}
?>

<h2>Edit Shop</h2>
<form method="post">
    <label>Shop Name:</label><br>
    <input type="text" name="shop_name" value="<?= $shop['shop_name'] ?>" required><br>

    <label>Owner Name:</label><br>
    <input type="text" name="owner_name" value="<?= $shop['owner_name'] ?>" required><br>

    <label>Location:</label><br>
    <textarea name="location" required><?= $shop['location'] ?></textarea><br>

    <label>Phone:</label><br>
    <input type="text" name="phone" value="<?= $shop['phone'] ?>" required><br><br>

    <button type="submit">Update Shop</button>
</form>
<a href="user_dashboard.php">Back</a>
