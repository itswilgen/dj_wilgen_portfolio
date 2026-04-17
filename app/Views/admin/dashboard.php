<?php

declare(strict_types=1);

$bookings = $bookings ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Admin Dashboard | DJ Wilgen Rivas') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <style>
        body { background-color: #0b0b0b; color: white; font-family: 'Inter', sans-serif; padding-top: 50px; }
        .admin-container { background: #111; border: 1px solid #333; border-radius: 8px; padding: 30px; }
        .table { color: white; border-color: #333; }
        .table thead { background: #0d6efd; color: white; }
        .logout-btn { color: #888; text-decoration: none; font-size: 0.9rem; }
        .logout-btn:hover { color: #ff4d4d; }
        #calendar {
            background: #212121;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #333;
            margin-bottom: 30px;
            color: white;
        }
        .fc-list-day-text, .fc-col-header-cell-cushion { color: #ffffff; text-decoration: none; }
        .fc-daygrid-day-number { color: #ccc; text-decoration: none; }
        .fc-event { cursor: pointer; border: none; background: #0d6efd; }
    </style>
</head>
<body>
<div class="container mt-4">
    <h4 class="mb-3"><i class="fas fa-calendar-alt me-2"></i> Event Schedule</h4>
    <div id="calendar"></div>
</div>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 fw-bold text-uppercase mb-0">Booking Dashboard</h1>
            <p class="text-secondary small">Manage your upcoming inquiries and events</p>
        </div>
        <a href="index.php" class="logout-btn"><i class="fas fa-house me-1"></i> Return to Site</a>
    </div>

    <?php if (($deleted ?? '') === 'success'): ?>
        <div class="alert alert-success">Booking deleted successfully.</div>
    <?php endif; ?>

    <?php if (($update ?? '') === 'success'): ?>
        <div class="alert alert-info bg-primary text-white border-0 py-2">Status updated and email notification sent.</div>
    <?php elseif (($update ?? '') === 'error'): ?>
        <div class="alert alert-danger border-0 py-2">Status update failed.</div>
    <?php endif; ?>

    <?php if (($upload ?? '') === 'success'): ?>
        <div class="alert alert-success">Gallery image uploaded successfully.</div>
    <?php elseif (($upload ?? '') === 'toolarge'): ?>
        <div class="alert alert-warning">Upload failed. The image is larger than 2MB.</div>
    <?php elseif (($upload ?? '') === 'invalidtype'): ?>
        <div class="alert alert-warning">Upload failed. Only JPG, PNG, and GIF images are allowed.</div>
    <?php elseif (($upload ?? '') === 'error'): ?>
        <div class="alert alert-danger">Upload failed. Please try again.</div>
    <?php endif; ?>

    <div class="admin-container shadow-lg">
        <div class="admin-container mb-4">
            <h5>Upload New Gallery Photo</h5>
            <form action="upload.php" method="POST" enctype="multipart/form-data" class="d-flex gap-2 flex-wrap">
                <input type="file" name="event_photo" class="form-control" required>
                <input type="hidden" name="csrf_token" value="<?= e($csrfToken ?? '') ?>">
                <button type="submit" class="btn btn-success">Upload</button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Date Received</th>
                        <th>Client Name</th>
                        <th>Event Date</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($bookings)): ?>
                        <?php foreach ($bookings as $row): ?>
                            <?php
                            $statusValue = $row['status'] ?? 'Pending';
                            $badgeClass = $statusValue === 'Confirmed'
                                ? 'bg-success'
                                : ($statusValue === 'Declined' ? 'bg-danger' : 'bg-warning text-dark');
                            ?>
                            <tr>
                                <td class="small text-secondary"><?= e(date('M d', strtotime((string) $row['created_at']))) ?></td>
                                <td>
                                    <strong><?= e($row['full_name']) ?></strong><br>
                                    <small class="text-secondary"><?= e($row['email']) ?></small>
                                </td>
                                <td><span class="badge bg-dark border border-secondary"><?= e($row['event_date']) ?></span></td>
                                <td><span class="badge bg-info text-dark"><?= e($row['payment_method']) ?></span></td>
                                <td>
                                    <form action="update_status.php" method="POST" class="d-inline">
                                        <input type="hidden" name="id" value="<?= e((string) $row['id']) ?>">
                                        <input type="hidden" name="csrf_token" value="<?= e($csrfToken ?? '') ?>">
                                        <select name="status" onchange="this.form.submit()" class="form-select form-select-sm <?= e($badgeClass) ?> border-0" style="width: 120px;">
                                            <option value="Pending" <?= selected($statusValue, 'Pending') ?>>Pending</option>
                                            <option value="Confirmed" <?= selected($statusValue, 'Confirmed') ?>>Confirmed</option>
                                            <option value="Declined" <?= selected($statusValue, 'Declined') ?>>Declined</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <form action="delete_booking.php" method="POST" onsubmit="return confirm('Delete this record?')">
                                        <input type="hidden" name="id" value="<?= e((string) $row['id']) ?>">
                                        <input type="hidden" name="csrf_token" value="<?= e($csrfToken ?? '') ?>">
                                        <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-secondary py-4">No bookings yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer class="mt-5 text-center">
        <p class="text-secondary small">&copy; 2026 Admin Panel • DJ Wilgen Rivas</p>
    </footer>

    <a href="logout.php" class="btn btn-outline-danger btn-sm mt-3">
        <i class="fas fa-sign-out-alt"></i> Secure Logout
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,listMonth'
        },
        events: 'fetch_events.php',
        eventColor: '#0d6efd',
        eventClick: function(info) {
            alert('Event: ' + info.event.title);
        }
    });

    calendar.render();
});
</script>
</body>
</html>
