<?php 
require_once __DIR__ . '/../../config/config.php'; 
require_once __DIR__ . '/../../includes/header.php';
?>

<h2 class="text-center mb-4">Login</h2>

<div class="d-flex justify-content-center">
    <form method="post" action="<?= LOGIN_PROCESS ?>" class="border p-4 rounded shadow bg-light" style="width: 350px;">
        <div class="mb-3">
            <label class="form-label">Username:</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
</div>


<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
