<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact | DJ Wilgen Rivas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #0b0b0b; color: white; font-family: 'Inter', sans-serif; margin: 0; }
        
        /* Video Background */
        .video-bg-container {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1; overflow: hidden;
        }
        #bg-video {
            position: absolute; top: 50%; left: 50%; min-width: 100%; min-height: 100%;
            transform: translate(-50%, -50%); object-fit: cover;
            filter: brightness(30%) blur(3px);
        }

        .navbar { background: rgba(0,0,0,0.85); backdrop-filter: blur(10px); }
        .contact-header { padding: 140px 0 40px 0; text-align: center; }
        
        /* Glassmorphism Card */
        .contact-card {
            background: rgba(22, 22, 22, 0.8);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        
        .social-link {
            display: flex; align-items: center; padding: 18px; margin-bottom: 15px;
            border-radius: 12px; text-decoration: none; color: white;
            font-weight: bold; transition: 0.3s; border: 1px solid rgba(255,255,255,0.1);
        }

        .social-link i { font-size: 1.5rem; margin-right: 20px; width: 30px; text-align: center; }
        
        /* Specific Colors */
        .fb:hover { background: #1877f2; border-color: #1877f2; transform: translateX(10px); }
        .wa:hover { background: #25d366; border-color: #25d366; transform: translateX(10px); }
        .tg:hover { background: #0088cc; border-color: #0088cc; transform: translateX(10px); }
        .mail:hover { background: #dd4b39; border-color: #dd4b39; transform: translateX(10px); }
    </style>
</head>
<body>

<div class="video-bg-container">
    <video autoplay muted loop playsinline id="bg-video">
        <source src="BG.MOV" type="video/mp4">
    </video>
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
                <li class="nav-item"><a class="nav-link px-3" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="about.php">About</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="events.php">Events</a></li>
                <li class="nav-item"><a class="nav-link px-3 active" href="contact.php">Contact</a></li>
                <li class="nav-item ms-lg-3">
                    <a class="nav-link px-4 btn btn-outline-primary rounded-pill text-white" href="booking.php" style="border: 2px solid #0d6efd !important;">Book Now</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<header class="contact-header">
    <div class="container">
        <h1 class="display-3 fw-bold">LET'S CONNECT</h1>
        <p class="lead text-light">Available for events, festivals, and club residencies.</p>
    </div>
</header>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="contact-card shadow-lg">
                    <h4 class="mb-4 text-primary text-uppercase letter-spacing-2">Direct Booking Channels</h4>
                    
                    <a href="https://web.facebook.com/wilgen.rivas.16" target="_blank" class="social-link fb">
                        <i class="fab fa-facebook-f"></i> Facebook / Wilgen Rivas
                    </a>


                    <a href="https://t.me/the_dj" target="_blank" class="social-link tg">
                        <i class="fab fa-telegram-plane"></i> Telegram / @the_dj
                    </a>

                    <a href="mailto:wilgenrivas123@gmail.com" class="social-link mail">
                        <i class="fas fa-envelope"></i> wilgenrivas123@gmail.com
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="py-5 text-center">
    <p class="text-secondary small">&copy; 2026 DJ WILGEN RIVAS • ALL RIGHTS RESERVED</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>