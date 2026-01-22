<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
?>

<?php
// Database Configuration
$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "dj_wilgen_db";

// Create Connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch bookings (Newest first)
$sql = "SELECT * FROM bookings ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | DJ Wilgen Rivas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #0b0b0b; color: white; font-family: 'Inter', sans-serif; padding-top: 50px; }
        .admin-container { background: #111; border: 1px solid #333; border-radius: 15px; padding: 30px; }
        .table { color: white; border-color: #333; }
        .table thead { background: #0d6efd; color: white; }
        .status-badge { font-size: 0.8rem; padding: 5px 12px; border-radius: 50px; }
        .event-type { color: #0d6efd; fw-bold; }
        tr:hover { background-color: rgba(255,255,255,0.05); }
        .logout-btn { color: #888; text-decoration: none; font-size: 0.9rem; }
        .logout-btn:hover { color: #ff4d4d; }
    </style>
</head>
<body>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 fw-bold text-uppercase mb-0">Booking Dashboard</h1>
            <p class="text-secondary small">Manage your upcoming inquiries and events</p>
        </div>
        <a href="index.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Return to Site</a>
    </div>

    <?php if(isset($_GET['deleted']) && $_GET['deleted'] == 'success'): ?>
    <div class="alert alert-success bg-success text-white border-0 py-2">
        Booking deleted successfully.
    </div>

<?php endif; ?>
    <div class="admin-container shadow-lg">
        <div class="table-responsive">
                <div class="admin-container mb-4">
        <h5>Upload New Gallery Photo</h5>
        <form action="upload.php" method="POST" enctype="multipart/form-data" class="d-flex gap-2">
            <input type="file" name="event_photo" class="form-control" required>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <button type="submit" class="btn btn-success">Upload</button>
        </form>

    </div>
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Date Received</th>
                        <th>Client Name</th>
                        <th>Email</th>
                        <th>Event Date</th>
                        <th>Event Type</th>
                        <th>Details</th>
                        <th>Payment</th>
                        <th>Actions</th> </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='small text-secondary'>" . date('M d, Y', strtotime($row['created_at'])) . "</td>";
                            echo "<td><strong>" . htmlspecialchars($row['full_name']) . "</strong></td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td><span class='badge bg-dark border border-secondary'>" . htmlspecialchars($row['event_date']) . "</span></td>";
                            echo "<td><span class='event-type text-uppercase small fw-bold'>" . htmlspecialchars($row['event_type']) . "</span></td>";
                            echo "<td><small class='text-secondary'>" . htmlspecialchars($row['details']) . "</small></td>";
                            echo "<td><span class='badge bg-info text-dark'>" . htmlspecialchars($row['payment_method']) . "</span></td>";
                            // The New Delete Button
                            echo "<td>
                                <form action='delete_booking.php' method='POST' onsubmit='return confirm(\"Are you sure you want to delete this booking?\")'>
                                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                                    <input type='hidden' name='csrf_token' value='" . $_SESSION['csrf_token'] . "'>
                                    <button type='submit' class='btn btn-outline-danger btn-sm'>
                                        <i class='fas fa-trash'></i>
                                    </button>
                                </form>
                            </td>";

                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center py-5 text-secondary'>No bookings found yet.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <footer class="mt-5 text-center">
        <p class="text-secondary small">&copy; 2026 Admin Panel • DJ Wilgen Rivas</p>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <a href="logout.php" class="btn btn-outline-danger btn-sm">
    <i class="fas fa-sign-out-alt"></i> Secure Logout
</a>
</body>
</html>