<?php include('db.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DJ Wilgen | Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f7f6; }
        .sidebar { height: 100vh; background: #000; color: #fff; padding: 20px; position: fixed; width: 250px; }
        .main-content { margin-left: 260px; padding: 20px; }
        .card-stat { border: none; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<div class="sidebar">
    <h3>Admin Panel</h3>
    <hr>
    <p>Welcome, Wilgen</p>
    <nav class="nav flex-column">
        <a class="nav-link text-white" href="#">Dashboard</a>
        <a class="nav-link text-white" href="#">Calendar View</a>
        <a class="nav-link text-white" href="#">Logout</a>
    </nav>
</div>

<div class="main-content">
    <h2 class="mb-4">Booking Management</h2>
    
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card card-stat bg-primary text-white p-3">
                <h5>Total Bookings</h5>
                <?php 
                $res = $conn->query("SELECT COUNT(*) as total FROM bookings");
                $row = $res->fetch_assoc();
                echo "<h3>" . $row['total'] . "</h3>";
                ?>
            </div>
        </div>
    </div>

    <div class="card p-4">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Payment</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM bookings ORDER BY event_date ASC";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['client_name']}</td>
                        <td>{$row['event_date']}</td>
                        <td>{$row['event_type']}</td>
                        <td><span class='badge bg-" . ($row['payment_status'] == 'Paid' ? 'success' : 'warning') . "'>{$row['payment_status']}</span></td>
                        <td>
                            <a href='update_booking.php?id={$row['id']}' class='btn btn-sm btn-outline-dark'>Update</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>