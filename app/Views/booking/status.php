<?php

declare(strict_types=1);

$bookingData = $bookingData ?? [];
$payment = $bookingData['payment'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= e($title ?? 'Booking Status | DJ Wilgen Rivas') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #0b0b0b;
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .status-card {
            background: #111;
            border: 1px solid #0d6efd;
            padding: 40px;
            border-radius: 8px;
            max-width: 500px;
            width: 100%;
            text-align: center;
        }
        .btn-home {
            background: #0d6efd;
            color: white;
            border-radius: 8px;
            padding: 10px 30px;
            text-decoration: none;
            display: inline-block;
        }
    </style>
</head>
<body>

<div class="status-card shadow-lg">
    <?php if (($status ?? 'error') === 'success'): ?>
        <h2 class="text-primary mb-3">REQUEST SENT!</h2>
        <p class="text-secondary">
            Thank you, <?= e($bookingData['name'] ?? '') ?>.<br>
            Your booking inquiry for <?= e($bookingData['date'] ?? '') ?> has been received.
        </p>

        <?php if ($payment === 'GCash'): ?>
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
            Invalid request or something went wrong.<br>
            Please try again.
        </p>
    <?php endif; ?>

    <br>
    <a href="index.php" class="btn-home">RETURN HOME</a>
</div>

</body>
</html>
