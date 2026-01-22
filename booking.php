
<?php
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book DJ Wilgen Rivas | Official Inquiry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background-color: #0b0b0b; 
            color: white; 
            font-family: 'Inter', sans-serif; 
            margin: 0;
            padding: 0;
        }

        /* Video Background Container */
        .video-bg-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        #bg-video {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            transform: translate(-50%, -50%);
            object-fit: cover;
            filter: brightness(30%) blur(2px); /* Makes the form pop */
        }

        /* Dark Overlay for better contrast */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: -1;
        }

        .navbar { background: rgba(0,0,0,0.8); backdrop-filter: blur(10px); }
        
        .booking-header {
            padding: 140px 0 40px 0;
            text-align: center;
        }

        /* Glassmorphism Effect for the Form */
        .booking-card {
            background: rgba(17, 17, 17, 0.85);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(13, 110, 253, 0.5);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.8);
        }

        .form-control, .form-select {
            background-color: rgba(26, 26, 26, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 12px;
        }

        .form-control:focus, .form-select:focus {
            background-color: #1a1a1a;
            color: white;
            border-color: #0d6efd;
            box-shadow: 0 0 10px rgba(13, 110, 253, 0.5);
        }

        label { color: #ccc; font-size: 0.85rem; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; }
        
        .btn-booking {
            background: #0d6efd;
            color: white;
            font-weight: bold;
            letter-spacing: 2px;
            padding: 15px;
            border: none;
            border-radius: 50px;
            transition: 0.3s;
        }

        .btn-booking:hover {
            background: #ffffff;
            color: #0d6efd;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(13, 110, 253, 0.3);
        }

        footer { background: rgba(0,0,0,0.8); }
    </style>
</head>
<body>

<div class="video-bg-container">
    <video autoplay muted loop playsinline id="bg-video">
        <source src="BG.MOV" type="video/mp4">
    </video>
    <div class="overlay"></div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="LOGO.jpg" alt="DJ Wilgen" height="60" style="filter: invert(1);">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto text-uppercase fw-bold align-items-center">
                <li class="nav-item"><a class="nav-link px-3 active" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="about.php">About</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="events.php">Events</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="contact.php">Contact</a></li>
                <li class="nav-item ms-lg-3">
                    <a class="nav-link px-4 btn btn-outline-primary rounded-pill text-white" href="booking.php" style="border: 2px solid #0d6efd !important;">Book Now</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<header class="booking-header">
    <div class="container">
        <h1 class="display-4 fw-bold text-white">RESERVE YOUR DATE</h1>
        <p class="lead text-light">Professional inquiry for DJ Wilgen Rivas</p>
    </div>
</header>

<section class="pb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="booking-card p-4 p-md-5">
                    <form action="process_booking.php" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label>Full Name / Company</label>
                                <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                            </div>
                            <div class="col-md-6">
                                <label>Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="email@domain.com" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label>Event Date</label>
                                <input type="date" name="date" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Event Category</label>
                                <select name="type" class="form-select" required>
                                    <option value="" selected disabled>Select...</option>
                                    <option value="Festival">Music Festival</option>
                                    <option value="Club">Club Night</option>
                                    <option value="Corporate">Corporate Event</option>
                                    <option value="Private">Private Party</option>
                                </select>
                            </div>
                            <div class="col-md-12">

                                <label>Preferred Payment Method</label>
                                <div class="d-flex gap-3 mt-2">
                                    <div class="form-check custom-option">
                                        <input class="form-check-input" type="radio" name="payment" id="cash" value="Cash" checked>
                                        <label class="form-check-label text-white" for="cash">
                                            <i class="fas fa-money-bill-wave me-2"></i> Cash
                                        </label>
                                    </div>
                                    <div class="form-check custom-option">
                                        <input class="form-check-input" type="radio" name="payment" id="gcash" value="GCash">
                                        <label class="form-check-label text-white" for="gcash">
                                            <i class="fas fa-mobile-alt me-2"></i> GCash
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label>Venue & Setup Requirements</label>
                                <textarea name="details" class="form-control" rows="4" placeholder="Mention location and any equipment needed..."></textarea>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-booking w-100">SUBMIT BOOKING REQUEST</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="py-4 text-center">
    <p class="text-secondary small mb-0">&copy; 2026 DJ WILGEN RIVAS • ALL RIGHTS RESERVED</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>