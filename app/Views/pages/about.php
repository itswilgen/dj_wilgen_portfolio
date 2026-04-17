<?php

declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'About | DJ Wilgen Rivas') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #0b0b0b; color: white; font-family: 'Inter', sans-serif; }
        .navbar { background: rgba(0,0,0,0.9); backdrop-filter: blur(10px); }
        .about-header { padding: 120px 0 60px 0; background: linear-gradient(to bottom, #1a1a1a, #0b0b0b); }
        .profile-img {
            width: 100%;
            border-radius: 8px;
            border: 2px solid #0d6efd;
            box-shadow: 0 0 30px rgba(13, 110, 253, 0.2);
        }
        .genre-badge {
            background: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
            border: 1px solid #0d6efd;
            padding: 8px 20px;
            border-radius: 8px;
            display: inline-block;
            margin: 5px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            transition: 0.3s;
        }
        .genre-badge:hover {
            background: #0d6efd;
            color: white;
            transform: scale(1.05);
        }
        .experience-card {
            background: #161616;
            border: 1px solid #333;
            transition: 0.3s;
        }
        .experience-card:hover {
            border-color: #0d6efd;
            background: #1a1a1a;
        }
        .highlight { color: #0d6efd; font-weight: bold; }
    </style>
</head>
<body>

<?php view('partials.public_nav', ['activePage' => $activePage ?? '']); ?>

<div class="about-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-5 mb-lg-0">
                <img src="FX405500.jpg" alt="DJ Wilgen Rivas" class="profile-img">
            </div>
            <div class="col-lg-7 ps-lg-5">
                <h6 class="text-primary text-uppercase fw-bold">The Artist</h6>
                <h1 class="display-4 fw-bold mb-4 text-uppercase">Wilgen Rivas</h1>
                <p class="lead mb-4">
                    Based in Tanjay City, <span class="highlight">DJ Wilgen Rivas</span> is an Open Format specialist known for high-energy sets that bridge culture and sound.
                </p>

                <h5 class="text-white text-uppercase fw-bold mb-3">Sound &amp; Genres</h5>
                <div class="mb-4">
                    <span class="genre-badge">EDM</span>
                    <span class="genre-badge">Hip-Hop</span>
                    <span class="genre-badge">Amapiano</span>
                    <span class="genre-badge">Afro</span>
                    <span class="genre-badge">House</span>
                    <span class="genre-badge">Techno House</span>
                    <span class="genre-badge">R&amp;B</span>
                    <span class="genre-badge">Budots</span>
                    <span class="genre-badge">Cha-Cha</span>
                    <span class="genre-badge">80s &amp; 90s</span>
                    <span class="genre-badge">Throwback</span>
                    <span class="genre-badge">Top 40</span>
                </div>

                <p class="text-secondary mb-4">
                    With extensive experience performing at major festivals like the <span class="highlight">Sinulog sa Tanjay</span> and <span class="highlight">Charter Day Music Fest</span>, Wilgen’s versatility allows him to cater to any audience, from modern club lovers to festive community crowds.
                </p>

                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <div class="p-3 border border-secondary rounded text-center">
                            <h4 class="mb-0 fw-bold">5+</h4>
                            <small class="text-secondary">Years Exp.</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 border border-secondary rounded text-center">
                            <h4 class="mb-0 fw-bold">100+</h4>
                            <small class="text-secondary">Events</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="py-5 bg-black">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">SERVICE SPECIALTIES</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card experience-card p-4 h-100 text-white">
                    <h3 class="h5 text-primary">Festivals</h3>
                    <p class="small text-secondary">Expertise in large-scale outdoor events, managing energy for thousands with EDM, House, and Festival Budots.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card experience-card p-4 h-100 text-white">
                    <h3 class="h5 text-primary">Club Nights</h3>
                    <p class="small text-secondary">Modern sets featuring Hip-Hop, Amapiano, Afrobeat, and Techno House for an elite nightlife experience.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card experience-card p-4 h-100 text-white">
                    <h3 class="h5 text-primary">Special Occasions</h3>
                    <p class="small text-secondary">Bringing the classics to life with 80s/90s Throwbacks, R&amp;B, and Cha-Cha for weddings and private parties.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="py-5 text-center">
    <p class="text-secondary small">&copy; 2026 DJ WILGEN RIVAS • TANJAY CITY • ALL RIGHTS RESERVED</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
