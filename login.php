<?php
session_start();

// If already logged in, go to admin panel
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_panel.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login'])) {
    $password = $_POST['password'];

    // Store hash ONCE (normally in DB or config)
    $hashed = '$2y$10$examplehashreplacewithrealone'; 
    // TEMP FIX BELOW ⬇️

    // TEMP SIMPLE VERSION (for now)
    if ($password === 'wilgen@22') {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_panel.php");
        exit;
    } else {
        $error = "Invalid password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0b0b0b; color: white; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .login-card { background: #111; padding: 30px; border-radius: 15px; border: 1px solid #0d6efd; width: 350px; }
    </style>
</head>
<body>
    <div class="login-card text-center">
        <h4 class="mb-4">DJ WILGEN ADMIN</h4>
        <?php if(isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
        <form method="POST">
            <input type="password" name="password" class="form-control mb-3" placeholder="Enter Password" required>
            <button name="login" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</body>
</html>