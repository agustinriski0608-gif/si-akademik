<?php

namespace App\Controllers;

class HomeController
{
    public function index(): void
    {
        redirect('/dashboard');
    }

    public function dashboard(): void
    {
        view('home/dashboard', ['title' => 'Dashboard']);
    }
}
