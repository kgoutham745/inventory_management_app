<?php
session_start();

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../auth/require.php';
require_once __DIR__ . '/../../includes/header.php';

requireRole('user');

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

// Fetch user's orders
$sql = "
    SELECT o.id, s.shop_name, o.quantity_boxes, o.status, o.created_at
    FROM orders o
    JOIN shops s ON o.shop_id = s.id
    WHERE s.user_id = ?
    ORDER BY o.created_at DESC
";
$stmt_orders = $conn->prepare($sql);
$stmt_orders->bind_param("i", $user_id);
$stmt_orders->execute();
$orders = $stmt_orders->get_result();

?>

<!-- === Order History === -->
<h3>Your Order History</h3>
<table border="1" cellpadding="10">
    <tr>
        <th>Order ID</th>
        <th>Shop</th>
        <th>Quantity (Boxes)</th>
        <th>Status</th>
        <th>Ordered On</th>
    </tr>
    <?php while ($row = $orders->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['shop_name']) ?></td>
        <td><?= $row['quantity_boxes'] ?></td>
        <td><?= $row['status'] ?></td>
        <td><?= $row['created_at'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<!-- === Your Shops === -->
<hr>
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
            <a href="../shop/edit_shop.php?id=<?= $row['id'] ?>">Edit</a> |
            <a href="../shop/delete_shop.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this shop?')">Delete</a> |
            <a href="../order/place_order.php?shop_id=<?= $row['id'] ?>">Place Order</a>

        </td>
    </tr>
    <?php endwhile; ?>
</table>

<!-- === ADD NEW SHOP (Accordion) === -->
<div class="accordion mb-4" id="addShopAccordion">
    <div class="accordion-item shadow">
        <h2 class="accordion-header" id="headingAddShop">
            <button class="accordion-button collapsed bg-secondary text-white" type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#collapseAddShop" 
                    aria-expanded="false" 
                    aria-controls="collapseAddShop">
                <i class="bi bi-shop me-2"></i> Add New Shop
            </button>
        </h2>
        <div id="collapseAddShop" class="accordion-collapse collapse" 
             aria-labelledby="headingAddShop" 
             data-bs-parent="#addShopAccordion">
            <div class="accordion-body">
                <form method="post" action="<?= ADD_SHOP_PAGE ?>">
                    <div class="mb-3">
                        <label for="shop_name" class="form-label">Shop Name:</label>
                        <input type="text" id="shop_name" name="shop_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="owner_name" class="form-label">Owner Name:</label>
                        <input type="text" id="owner_name" name="owner_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Location:</label>
                        <textarea id="location" name="location" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone:</label>
                        <input type="text" id="phone" name="phone" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add Shop
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<hr>


<?php require_once __DIR__ . '/../../includes/footer.php'; ?>