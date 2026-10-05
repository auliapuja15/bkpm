<?php

namespace App\Controllers;

class AuthController
{
    public function login()
    {
        require __DIR__ . '/../Views/Auth/login.php';
    }

    public function processLogin()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($username === 'admin' && $password === '12345') {

            $_SESSION['user'] = $username;
            $_SESSION['flash'] = 'Selamat datang, Admin';

            header('Location: /si-akademik6/public/dashboard');
            exit;

        } else {

            $_SESSION['error'] = 'Username atau password salah';

            header('Location: /si-akademik6/public/login');
            exit;
        }
    }

    public function logout()
    {
        $_SESSION = [];

        $_SESSION['flash'] = 'Anda telah logout';

        header('Location: /si-akademik6/public/login');
        exit;
    }
}