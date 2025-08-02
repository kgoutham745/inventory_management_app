<?php
// require 'db.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../config/config.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle update
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role     = $_POST['role'];

    $sql = "UPDATE users SET username=?, password=?, role=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $username, $password, $role, $id);

    if ($stmt->execute()) {
        header("Location: " . ADMIN_HOME_PAGE);
    } else {
        echo "Error updating user.";
    }
} else {
    // Show form
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}
?>

<?php if (isset($user)): ?>
    <h2>Edit User</h2>
    <form method="post">
        <label>Username:</label><br>
        <input type="text" name="username" value="<?= $user['username'] ?>" required><br>

        <label>Password:</label><br>
        <input type="text" name="password" value="<?= $user['password'] ?>" required><br>

        <label>Role:</label><br>
        <select name="role">
            <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
        </select><br><br>

        <button type="submit">Update User</button>
    </form>
    <a href="admin_dashboard.php">Back to Dashboard</a>
<?php else: ?>
    <p>User not found.</p>
<?php endif; ?>
