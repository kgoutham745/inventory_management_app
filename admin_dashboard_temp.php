<!-- <?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<h2>Welcome Admin: <?php echo $_SESSION['username']; ?></h2>
<a href="logout.php">Logout</a> -->

<?php
session_start();
require 'db.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch all users
$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
<h2>Welcome Admin: <?php echo $_SESSION['username']; ?></h2>
<a href="logout.php">Logout</a>

<h3>All Users</h3>
<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
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

</body>
</html>

