<!-- <?php
session_start();

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../config/config.php';

if ($_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}
?>
<h2>Welcome User: <?php echo $_SESSION['username']; ?></h2>
<a href="logout.php">Logout</a> -->


<?php
session_start();
require 'db.php';

if ($_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'] ?? null; // ensure user_id is set
if (!$user_id) {
    // Fetch from DB if not in session
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $_SESSION['username']);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $_SESSION['user_id'] = $res['id'];
    $user_id = $res['id'];
}

// Fetch shops for this user
$stmt = $conn->prepare("SELECT * FROM shops WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$shops = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
</head>
<body>
<h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
<a href="logout.php">Logout</a>

<h3>Your Shops</h3>
<table border="1" cellpadding="10">
    <tr>
        <th>Shop Name</th>
        <th>Owner Name</th>
        <th>Location</th>
        <th>Phone</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $shops->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($row['shop_name']) ?></td>
        <td><?= htmlspecialchars($row['owner_name']) ?></td>
        <td><?= htmlspecialchars($row['location']) ?></td>
        <td><?= htmlspecialchars($row['phone']) ?></td>
        <td>
            <a href="edit_shop.php?id=<?= $row['id'] ?>">Edit</a> |
            <a href="delete_shop.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this shop?')">Delete</a> |
            <a href="place_order.php?shop_id=<?= $row['id'] ?>">Place Order</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<h3>Add New Shop</h3>
<form method="post" action="add_shop.php">
    <label>Shop Name:</label><br>
    <input type="text" name="shop_name" required><br>

    <label>Owner Name:</label><br>
    <input type="text" name="owner_name" required><br>

    <label>Location:</label><br>
    <textarea name="location" required></textarea><br>

    <label>Phone:</label><br>
    <input type="text" name="phone" required><br><br>

    <button type="submit">Add Shop</button>
</form>
</body>
</html>
