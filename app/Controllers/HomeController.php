<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class HomeController extends BaseController
{
    public function index(): string
    {
        $cart = \Config\Services::cart();
        helper('auth');

        $username = logged_in() ? user()->username : 'Guest';

        return view('index', [
            'username' => $username,
            'cart' => $cart
        ]);
    }

    public function category(): string
    {
        return view('category', ['cart' => \Config\Services::cart()]);
    }

    public function productdetail(): string
    {
        return view('productdetail', ['cart' => \Config\Services::cart()]);
    }

    public function checkout(): string
    {
        return view('checkout', ['cart' => \Config\Services::cart()]);
    }

    public function ordersukses(): string
    {
        return view('ordersukses', ['cart' => \Config\Services::cart()]);
    }

    public function myorder(): string
    {
        return view('myorder', ['cart' => \Config\Services::cart()]);
    }

    
}
