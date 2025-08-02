<?php
session_start();
// require 'db.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../auth/require.php';
require_once __DIR__ . '/models.php';
require_once __DIR__ . '/../../includes/header.php';

requireRole('admin');

// Fetch all users
$users = getAllUsers($conn);

// Fetch all orders with shop name and user who placed it
$order_result = getAllOrders($conn);

// Fetch all shops added by the current user
$shop_result = getAllShops($conn);
?>


<!-- === ORDER MANAGEMENT === -->
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
                <form method="post" action="../order/update_order_status.php" style="display:inline;">
                    <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                    <button type="submit" name="status" value="Approved">Approve</button>
                    <button type="submit" name="status" value="Rejected">Reject</button>
                </form>
            <?php elseif ($order['status'] === 'Approved'): ?>
                <form method="post" action="../order/update_order_status.php" style="display:inline;">
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

<!-- === USERS TABLE === -->
<hr>
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

<!-- === ADD NEW USER (Accordion) === -->
<div class="accordion mb-4" id="addUserAccordion">
    <div class="accordion-item shadow">
        <h2 class="accordion-header" id="headingAddUser">
            <button class="accordion-button collapsed bg-secondary text-white" type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#collapseAddUser" 
                    aria-expanded="false" 
                    aria-controls="collapseAddUser">
                <i class="bi bi-person-plus me-2"></i> Add New User
            </button>
        </h2>
        <div id="collapseAddUser" class="accordion-collapse collapse" 
             aria-labelledby="headingAddUser" 
             data-bs-parent="#addUserAccordion">
            <div class="accordion-body">
                <form method="post" action="add_user.php">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" id="username" name="username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="text" id="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role:</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-person-plus"></i> Add User
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<hr>


<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
