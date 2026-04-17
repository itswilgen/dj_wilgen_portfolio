<?php

declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= e($title ?? 'Admin Login') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0b0b0b; color: white; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 24px; }
        .login-card { background: #111; padding: 30px; border-radius: 8px; border: 1px solid #0d6efd; width: 350px; }
    </style>
</head>
<body>
    <div class="login-card text-center">
        <h4 class="mb-4">DJ WILGEN ADMIN</h4>
        <?php if (!empty($error ?? null)): ?>
            <p class="text-danger"><?= e($error) ?></p>
        <?php endif; ?>
        <form method="POST" action="login.php">
            <input type="password" name="password" class="form-control mb-3" placeholder="Enter Password" required>
            <button name="login" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</body>
</html>
