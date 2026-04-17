<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Models\AdminUser;

final class AuthController extends Controller
{
    public function showLogin(): void
    {
        if (AdminUser::check()) {
            $this->redirect('admin_panel.php');
        }

        $this->render('admin.login', [
            'title' => 'Admin Login',
            'error' => null,
        ]);
    }

    public function login(): void
    {
        if (!Request::isPost()) {
            $this->redirect('login.php');
        }

        $password = (string) Request::post('password', '');

        if (AdminUser::login($password)) {
            $this->redirect('admin_panel.php');
        }

        $this->render('admin.login', [
            'title' => 'Admin Login',
            'error' => 'Invalid password. Please try again.',
        ]);
    }

    public function logout(): void
    {
        AdminUser::logout();
        $this->redirect('login.php');
    }
}
