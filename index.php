<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DJ Wilgen Rivas | Official Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #0b0b0b; color: white; font-family: 'Inter', sans-serif; }
        
        /* Video Background */
        .hero-section {
            position: relative; height: 100vh; width: 100%;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden; text-align: center;
        }
        #bg-video {
            position: absolute; top: 50%; left: 50%; min-width: 100%; min-height: 100%;
            z-index: -1; transform: translateX(-50%) translateY(-50%);
            object-fit: cover; filter: brightness(35%);
        }

        /* Intro Styling */
        .intro-section { background: linear-gradient(180deg, #0b0b0b 0%, #161616 100%); border-bottom: 1px solid #333; }
        .stat-number { font-size: 2.5rem; font-weight: 800; color: #0d6efd; display: block; }
        .stat-label { text-transform: uppercase; font-size: 0.8rem; letter-spacing: 2px; color: #888; }

        /* Gallery Styling */
            .video-container {
        position: relative;
        border-radius: 15px;
        overflow: hidden;
        border: 1px solid #333;
        transition: 0.4s;
    }
    .video-container:hover {
        border-color: #0d6efd;
        transform: scale(1.02);
    }
    .gallery-video {
        width: 100%;
        height: 500px; /* Adjusted for portrait video content */
        object-fit: cover;
        filter: grayscale(30%);
        transition: 0.4s;
    }
    .video-container:hover .gallery-video {
        filter: grayscale(0%);
    }
    .video-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0,0,0,0.8));
        color: white;
        padding: 20px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

        .navbar { background: rgba(0,0,0,0.9); backdrop-filter: blur(10px); }
        .hero-content h1 { letter-spacing: 5px; text-shadow: 2px 2px 10px rgba(0,0,0,0.8); }
        .btn-primary { background-color: #0d6efd; border: none; padding: 15px 40px; border-radius: 50px; font-weight: bold; }
    </style>
</head>
<body>

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

<header class="hero-section">
    <video autoplay muted loop playsinline id="bg-video">
        <source src="BG.MOV" type="video/mp4">
    </video>
    <div class="hero-content">
        <h1 class="display-1 fw-bold text-uppercase">Wilgen Rivas</h1>
        <p class="lead fs-3 mb-4">OPEN FORMAT • HOUSE • HIP-HOP • ELECTRONIC</p>
        <a href="booking.php" class="btn btn-primary btn-lg">BOOK ONLINE</a>
    </div>
</header>

<section class="intro-section py-5 text-center">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="display-6 fw-bold mb-3">Elevating Every Beat</h2>
                <p class="lead text-secondary mb-5">
                    With over <span class="text-white fw-bold">5 years</span> of commanding the decks, DJ Wilgen Rivas delivers a high-octane blend of 
                    <span class="text-white">House, Hip-Hop, and Electronic</span> music. From massive music festivals to elite club nights, 
                    his signature open-format style ensures an unforgettable experience for every crowd.
                </p>
            </div>
        </div>
        <div class="row g-4 mt-2">
            <div class="col-md-4">
                <span class="stat-number">100+</span>
                <span class="stat-label">Shows Performed</span>
            </div>
            <div class="col-md-4">
                <span class="stat-number">Open Format</span>
                <span class="stat-label">Genre Specialist</span>
            </div>
            <div class="col-md-4">
                <span class="stat-number">Elite</span>
                <span class="stat-label">Sound & Vibe</span>
            </div>
        </div>
    </div>
</section>

<section id="gallery" class="py-5 bg-black">
    <div class="container text-center">
        <h2 class="display-5 fw-bold mb-5">LIVE PERFORMANCE HIGHLIGHTS</h2>
        <div class="row g-4">
            
            <div class="col-md-4">
                <div class="video-container">
                    <video class="gallery-video" muted loop playsinline onmouseover="this.play()" onmouseout="this.pause()">
                        <source src="g2.MOV" type="video/mp4">
                    </video>
                    <div class="video-overlay">Festival Energy</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="video-container">
                    <video class="gallery-video" muted loop playsinline onmouseover="this.play()" onmouseout="this.pause()">
                        <source src="g3.MOV" type="video/mp4">
                    </video>
                    <div class="video-overlay">Mixing Live</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="video-container">
                    <video class="gallery-video" muted loop playsinline onmouseover="this.play()" onmouseout="this.pause()">
                        <source src="g5.MOV" type="video/mp4">
                    </video>
                    <div class="video-overlay">Stage Presence</div>
                </div>
            </div>

        </div>
        
        <div class="mt-5">
            <a href="events.php" class="btn btn-outline-primary btn-lg">VIEW ALL PAST EVENTS</a>
        </div>
    </div>
</section>

<footer class="py-5 text-center">
    <p class="text-secondary small">&copy; 2026 DJ WILGEN RIVAS • ALL RIGHTS RESERVED</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>