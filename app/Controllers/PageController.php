<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Gallery;

final class PageController extends Controller
{
    public function home(): void
    {
        $this->render('pages.home', [
            'activePage' => 'home',
            'title' => 'DJ Wilgen Rivas | Official Website',
        ]);
    }

    public function about(): void
    {
        $this->render('pages.about', [
            'activePage' => 'about',
            'title' => 'About | DJ Wilgen Rivas',
        ]);
    }

    public function contact(): void
    {
        $this->render('pages.contact', [
            'activePage' => 'contact',
            'title' => 'Contact | DJ Wilgen Rivas',
        ]);
    }

    public function events(): void
    {
        $gallery = new Gallery();

        $this->render('pages.events', [
            'activePage' => 'events',
            'title' => 'Events & Portfolio | DJ Wilgen Rivas',
            'images' => $gallery->all(),
        ]);
    }
}
