<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: booking.php");
    exit;
}

include 'db_config.php';

$status = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // CSRF check
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $status = "error";
    } else {

        // Sanitize inputs
        $name    = trim($_POST['name'] ?? '');
        $email   = trim($_POST['email'] ?? '');
        $date    = $_POST['date'] ?? '';
        $type    = trim($_POST['type'] ?? '');
        $payment = trim($_POST['payment'] ?? '');
        $details = trim($_POST['details'] ?? '');

         $email = str_replace(["\r", "\n"], '', $email);
        // Validate required fields
        if (
            empty($name) || empty($email) || empty($date) ||
            empty($type) || empty($payment)
        ) {
            $status = "error";
        }

        // Email validation
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $status = "error";
        }

        // Whitelist payment methods
        $allowed_payments = ['GCash', 'Cash'];
        if (!in_array($payment, $allowed_payments, true)) {
            $status = "error";
        }

        else {
            // Prepared Statement (SQL Injection safe)
            $stmt = $conn->prepare(
                "INSERT INTO bookings
                (full_name, email, event_date, event_type, payment_method, details)
                VALUES (?, ?, ?, ?, ?, ?)"
            );

            if ($stmt) {
                $stmt->bind_param(
                    "ssssss",
                    $name, $email, $date, $type, $payment, $details
                );

                if ($stmt->execute()) {
                    $status = "success";
                    unset($_SESSION['csrf_token']); // one-time use

                        $to = $email;
                        $subject = "Booking Request Received | DJ Wilgen Rivas";

                        $headers  = "MIME-Version: 1.0\r\n";
                        $headers .= "Content-type:text/html;charset=UTF-8\r\n";
                        $headers .= "From: DJ Wilgen Rivas <no-reply@yourdomain.com>\r\n";
                        $headers .= "Reply-To: contact@yourdomain.com\r\n";

                        $message = "
                        <html>
                        <body style='font-family: Arial, sans-serif; background:#0b0b0b; color:#ffffff; padding:20px;'>
                            <div style='max-width:600px; margin:auto; background:#111; padding:30px; border-radius:10px;'>
                                <h2 style='color:#0d6efd;'>Booking Request Received</h2>
                                <p>Hi <strong>{$name}</strong>,</p>

                                <p>Thank you for your inquiry. We’ve received your booking request with the following details:</p>

                                <ul>
                                    <li><strong>Event Date:</strong> {$date}</li>
                                    <li><strong>Event Type:</strong> {$type}</li>
                                    <li><strong>Payment Method:</strong> {$payment}</li>
                                </ul>

                                <p>We’ll review your request and contact you shortly to confirm availability.</p>

                                <hr style='border:1px solid #333;'>

                                <p style='font-size:12px; color:#aaa;'>
                                    DJ Wilgen Rivas<br>
                                    Professional DJ Services
                                </p>
                            </div>
                        </body>
                        </html>
                        ";

                        mail($to, $subject, $message, $headers);

                        $admin_to = "wilgenrivas123@gmail.com";
                        $admin_subject = "NEW BOOKING REQUEST";

                        $admin_headers  = "MIME-Version: 1.0\r\n";
                        $admin_headers .= "Content-type:text/html;charset=UTF-8\r\n";
                        $admin_headers .= "From: Booking System <no-reply@yourdomain.com>\r\n";

                        $admin_message = "
                        <html>
                        <body style='font-family: Arial;'>
                            <h2>New Booking Request</h2>
                            <p><strong>Name:</strong> {$name}</p>
                            <p><strong>Email:</strong> {$email}</p>
                            <p><strong>Date:</strong> {$date}</p>
                            <p><strong>Event Type:</strong> {$type}</p>
                            <p><strong>Payment:</strong> {$payment}</p>
                            <p><strong>Details:</strong><br>{$details}</p>
                        </body>
                        </html>
                        ";

                        mail($admin_to, $admin_subject, $admin_message, $admin_headers);
                        

                } else {
                    error_log("DB Execute Error: " . $stmt->error);
                    $status = "error";
                }

                $stmt->close();
            } else {
                error_log("DB Prepare Error: " . $conn->error);
                $status = "error";
            }
        }
    }
}

$conn->close();

// Safe output function
function e($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Booking Status | DJ Wilgen Rivas</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background:#0b0b0b; color:white;
    height:100vh; display:flex;
    align-items:center; justify-content:center;
}
.status-card {
    background:#111; border:1px solid #0d6efd;
    padding:40px; border-radius:20px;
    max-width:500px; text-align:center;
}
.btn-home {
    background:#0d6efd; color:white;
    border-radius:50px; padding:10px 30px;
    text-decoration:none;
}
</style>
</head>
<body>

<div class="status-card shadow-lg">

<?php if ($status === "success"): ?>

    <h2 class="text-primary mb-3">REQUEST SENT!</h2>
    <p class="text-secondary">
        Thank you, <?= e($name) ?>.<br>
        Your booking inquiry for <?= e($date) ?> has been received.
    </p>

    <?php if ($payment === "GCash"): ?>
        <div class="mt-4 p-4 border border-primary rounded">
            <p class="small text-primary fw-bold">SCAN TO PAY</p>
            <img src="GcashQR.jpg" alt="GCash QR" width="200">
            <p class="fw-bold mt-2">0962 723 6299</p>
            <p class="small text-secondary">Wilgen Rivas</p>
        </div>
    <?php else: ?>
        <p class="text-info mt-3">Payment Method: Cash on Venue</p>
    <?php endif; ?>

<?php else: ?>

    <h2 class="text-danger mb-3">ERROR</h2>
    <p class="text-secondary">
        Invalid request or something went wrong.
        Please try again.
    </p>

<?php endif; ?>

<br>
<a href="index.php" class="btn-home">RETURN HOME</a>

</div>
</body>
</html>
