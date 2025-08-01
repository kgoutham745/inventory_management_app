<?php
session_start();
require 'db.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch all users
$users = $conn->query("SELECT * FROM users");

// Fetch all orders with shop name and user who placed it
$sql = "
    SELECT o.id AS order_id, o.quantity_boxes, o.status, o.created_at,
           s.shop_name, s.owner_name, u.username
    FROM orders o
    JOIN shops s ON o.shop_id = s.id
    JOIN users u ON s.user_id = u.id
    ORDER BY o.created_at DESC
";
$order_result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
<h2>Welcome Admin: <?php echo $_SESSION['username']; ?></h2>
<a href="logout.php">Logout</a>

<!-- === USERS TABLE === -->
<h3>All Users</h3>
<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $users->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['username'] ?></td>
        <td><?= $row['role'] ?></td>
        <td>
            <a href="edit_user.php?id=<?= $row['id'] ?>">Edit</a> |
            <a href="delete_user.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this user?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<!-- === ADD NEW USER === -->
<h3>Add New User</h3>
<form method="post" action="add_user.php">
    <label>Username:</label><br>
    <input type="text" name="username" required><br>

    <label>Password:</label><br>
    <input type="text" name="password" required><br>

    <label>Role:</label><br>
    <select name="role" required>
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select><br><br>

    <button type="submit">Add User</button>
</form>

<!-- === ORDER MANAGEMENT === -->
<hr>
<h3>All Orders</h3>
<table border="1" cellpadding="10">
    <tr>
        <th>Order ID</th>
        <th>Shop Name</th>
        <th>Owner Name</th>
        <th>User</th>
        <th>Quantity (Boxes)</th>
        <th>Status</th>
        <th>Ordered On</th>
        <th>Actions</th>
    </tr>
    <?php while ($order = $order_result->fetch_assoc()): ?>
    <tr>
        <td><?= $order['order_id'] ?></td>
        <td><?= htmlspecialchars($order['shop_name']) ?></td>
        <td><?= htmlspecialchars($order['owner_name']) ?></td>
        <td><?= htmlspecialchars($order['username']) ?></td>
        <td><?= $order['quantity_boxes'] ?></td>
        <td><?= $order['status'] ?></td>
        <td><?= $order['created_at'] ?></td>
        <td>
            <?php if ($order['status'] === 'Pending'): ?>
                <form method="post" action="update_order_status.php" style="display:inline;">
                    <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                    <button type="submit" name="status" value="Approved">Approve</button>
                    <button type="submit" name="status" value="Rejected">Reject</button>
                </form>
            <?php elseif ($order['status'] === 'Approved'): ?>
                <form method="post" action="update_order_status.php" style="display:inline;">
                    <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                    <button type="submit" name="status" value="Fulfilled">Fulfill</button>
                </form>
            <?php else: ?>
                -
            <?php endif; ?>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<!-- === SHOP LIST SECTION === -->
<hr>
<h3>All Shops</h3>
<table border="1" cellpadding="10">
    <tr>
        <th>Shop ID</th>
        <th>Shop Name</th>
        <th>Owner Name</th>
        <th>Location</th>
        <th>Phone</th>
        <th>Added By (User)</th>
        <th>Created At</th>
    </tr>
    <?php
    $shop_query = "
        SELECT s.*, u.username
        FROM shops s
        JOIN users u ON s.user_id = u.id
        ORDER BY s.created_at DESC
    ";
    $shop_result = $conn->query($shop_query);
    while ($shop = $shop_result->fetch_assoc()):
    ?>
    <tr>
        <td><?= $shop['id'] ?></td>
        <td><?= htmlspecialchars($shop['shop_name']) ?></td>
        <td><?= htmlspecialchars($shop['owner_name']) ?></td>
        <td><?= htmlspecialchars($shop['location']) ?></td>
        <td><?= htmlspecialchars($shop['phone']) ?></td>
        <td><?= htmlspecialchars($shop['username']) ?></td>
        <td><?= $shop['created_at'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>


</body>
</html>
