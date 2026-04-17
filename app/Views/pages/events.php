<?php

declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Events & Portfolio | DJ Wilgen Rivas') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #0b0b0b; color: white; font-family: 'Inter', sans-serif; }
        .navbar { background: rgba(0,0,0,0.9); backdrop-filter: blur(10px); }
        .page-header {
            padding: 140px 0 60px 0;
            background: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.9)), url('IMG_6890.jpg');
            background-size: cover; background-position: center; text-align: center;
        }
        .event-card {
            background: #111; border: 1px solid #222; border-radius: 8px;
            overflow: hidden; transition: 0.4s; margin-bottom: 20px;
        }
        .event-card:hover { border-color: #0d6efd; transform: translateY(-5px); }
        .event-img { width: 100%; height: 300px; object-fit: cover; }
        .experience-section {
            background: #111; border-radius: 8px; border: 1px solid #222;
            padding: 40px; margin-top: 50px;
        }
        .list-item {
            padding: 15px 0; border-bottom: 1px solid #222;
            display: flex; align-items: center; font-size: 1.1rem;
        }
        .list-item:last-child { border-bottom: none; }
        .list-item i { color: #0d6efd; margin-right: 20px; font-size: 1.2rem; }
    </style>
</head>
<body>

<?php view('partials.public_nav', ['activePage' => $activePage ?? '']); ?>

<header class="page-header">
    <div class="container">
        <h1 class="display-3 fw-bold text-uppercase">Event Highlights</h1>
        <p class="lead text-secondary">Visuals from past performances and festivals.</p>
    </div>
</header>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <?php if (!empty($images ?? [])): ?>
                <?php foreach ($images as $image): ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="event-card shadow-lg">
                            <img src="<?= e($image['path']) ?>" class="event-img" alt="DJ Wilgen Live">
                            <div class="p-3 text-center">
                                <span class="small text-secondary text-uppercase fw-bold"><?= e($image['name']) ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-secondary">Add event photos to the `gallery_images` folder to display them here.</p>
                </div>
            <?php endif; ?>
        </div>

        <hr class="my-5 border-secondary">

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="experience-section">
                    <h2 class="text-center fw-bold mb-4 text-primary text-uppercase">Professional Experience</h2>
                    <p class="text-center text-secondary mb-5">Available for professional DJ services in the following categories:</p>

                    <div class="list-item"><i class="fas fa-check-circle"></i> Corporate Events &amp; Product Launches</div>
                    <div class="list-item"><i class="fas fa-check-circle"></i> Wedding After Party DJ Sets</div>
                    <div class="list-item"><i class="fas fa-check-circle"></i> Beauty Pageants &amp; Stage Directing</div>
                    <div class="list-item"><i class="fas fa-check-circle"></i> Major Music Festivals &amp; Concerts</div>
                    <div class="list-item"><i class="fas fa-check-circle"></i> SK Party Nights &amp; Local Fiestas</div>
                    <div class="list-item"><i class="fas fa-check-circle"></i> Any Occasion / Private Celebrations</div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="booking.php" class="btn btn-primary btn-lg px-5 rounded-pill fw-bold">BOOK NOW</a>
        </div>
    </div>
</section>

<footer class="py-5 text-center">
    <p class="text-secondary small">&copy; 2026 DJ WILGEN RIVAS • TANJAY CITY • PHILIPPINES</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
