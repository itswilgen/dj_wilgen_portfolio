<?php
session_start();

/* 1️⃣ Block unauthorized users */
if (!isset($_SESSION['admin_logged_in'])) {
    http_response_code(403);
    exit("Access denied");
}

/* 2️⃣ Allow POST only */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit("Invalid request method");
}

/* 3️⃣ CSRF token validation */
if (
    !isset($_POST['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    http_response_code(403);
    exit("Invalid CSRF token");
}

/* 4️⃣ Validate booking ID */
if (!isset($_POST['id']) || !ctype_digit($_POST['id'])) {
    http_response_code(400);
    exit("Invalid booking ID");
}

$booking_id = (int) $_POST['id'];

/* 5️⃣ Database connection */
$conn = new mysqli("localhost", "root", "", "dj_wilgen_db");
if ($conn->connect_error) {
    http_response_code(500);
    exit("Database connection failed");
}

/* 6️⃣ Secure delete (Prepared Statement) */
$stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
$stmt->bind_param("i", $booking_id);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();

    header("Location: admin_panel.php?deleted=success");
    exit;
} else {
    http_response_code(500);
    exit("Delete failed");
}
