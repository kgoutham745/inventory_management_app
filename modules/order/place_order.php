<?php
session_start();
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../auth/require.php';


requireRole('user');

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
        header("Location: " . USER_HOME_PAGE);
        exit();
    } else {
        echo "Error placing order.";
    }
}
?>

<?php require_once __DIR__ . '/../../includes/header.php'; ?>

<div class="d-flex justify-content-center align-items-center">
    <div class="card shadow p-4">
        <h4 class="text-center mb-4">
            <i class="bi bi-box"></i> Place Order for 
            <span class="text-primary"><?= htmlspecialchars($shop['shop_name']) ?></span>
        </h4>

        <form method="post">
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity (in boxes):</label>
                <input type="number" id="quantity" name="quantity" min="1" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100">
                <i class="bi bi-cart-plus"></i> Submit Order
            </button>
        </form>

        <div class="mt-3 text-center">
            <a href="../user/user_dashboard.php" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>
</div>


<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
