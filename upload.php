<?php
session_start();

// Admin check
if (!isset($_SESSION['admin_logged_in'])) {
    http_response_code(403);
    exit("Access denied");
}

// CSRF check
if (
    !isset($_POST['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    http_response_code(403);
    exit("Invalid CSRF token");
}

// Only handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['event_photo'])) {
    
    $file = $_FILES['event_photo'];
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 2 * 1024 * 1024; // 2MB
    
    // Check file size
    if ($file['size'] > $max_size) {
        header("Location: admin_panel.php?upload=toolarge");
        exit;
    }
    
    // Check MIME type
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($file['tmp_name']);
    if (!in_array($mime_type, $allowed_types)) {
        header("Location: admin_panel.php?upload=invalidtype");
        exit;
    }
    
    // Generate unique file name
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $new_filename = uniqid('gallery_', true) . '.' . $ext;
    $target_dir = __DIR__ . "/gallery_images/";
    $target_file = $target_dir . $new_filename;
    
    // Move the file
    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        header("Location: admin_panel.php?upload=success");
        exit;
    } else {
        error_log("Upload failed for file: " . $file['name']);
        header("Location: admin_panel.php?upload=error");
        exit;
    }
} else {
    http_response_code(405);
    exit("Invalid request method");
}
?>
