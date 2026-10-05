<?php

namespace App\Controllers;

class AuthController
{
    // Menampilkan halaman login
    public function login()
    {
        require __DIR__ . '/../Views/Auth/login.php';
    }

    // Memproses login
    public function processLogin()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($username === 'admin' && $password === '12345') {

            $_SESSION['user'] = $username;
            $_SESSION['logged_in'] = true;
            $_SESSION['flash'] = 'Selamat datang, Admin';

            header('Location: /si-akademik8/public/dashboard');
            exit;

        } else {

            $_SESSION['error'] = 'Username atau password salah';

            header('Location: /si-akademik8/public/login');
            exit;
        }
    }

    // Logout
    public function logout()
    {
        $_SESSION = [];

        session_destroy();

        header('Location: /si-akademik8/public/login');
        exit;
    }
}