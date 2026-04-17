<?php

declare(strict_types=1);

require __DIR__ . '/app/bootstrap.php';

$controller = new App\Controllers\AuthController();

if (App\Core\Request::isPost()) {
    $controller->login();
    return;
}

$controller->showLogin();
