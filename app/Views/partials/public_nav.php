<?php

declare(strict_types=1);

$activePage = $activePage ?? '';
?>
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
                <li class="nav-item"><a class="nav-link px-3 <?= $activePage === 'home' ? 'active' : '' ?>" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link px-3 <?= $activePage === 'about' ? 'active' : '' ?>" href="about.php">About</a></li>
                <li class="nav-item"><a class="nav-link px-3 <?= $activePage === 'events' ? 'active' : '' ?>" href="events.php">Events</a></li>
                <li class="nav-item"><a class="nav-link px-3 <?= $activePage === 'contact' ? 'active' : '' ?>" href="contact.php">Contact</a></li>
                <li class="nav-item ms-lg-3">
                    <a class="nav-link px-4 btn btn-outline-primary rounded-pill text-white <?= $activePage === 'booking' ? 'active' : '' ?>" href="booking.php" style="border: 2px solid #0d6efd !important;">Book Now</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
