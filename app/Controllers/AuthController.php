<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AuthController extends BaseController
{
    // public function index(): string
    // {
    //     return view('home');
    // }

    public function login()
    {
        // Ambil konfigurasi Auth
        $config = config('Auth');

        // Kirimkan konfigurasi ke view
        return view('auth/login', ['config' => $config]);
    }

    public function register()
    {
        // Ambil konfigurasi Auth (jika dibutuhkan untuk view register)
        

        // Kirimkan konfigurasi ke view
        return view('auth/register');
    }
    

    
}
