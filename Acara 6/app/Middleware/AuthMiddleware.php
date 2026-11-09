<?php

class AuthMiddleware
{
    public function handle()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /si-akademik/Acara%206/public/login');
            exit;
        }
    }
}
