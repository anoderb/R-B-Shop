<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Home Routes
$routes->get('/', 'HomeController::index');
$routes->get('/home', 'HomeController::index', ['filter' => 'role:user']);
$routes->get('/cart', 'HomeController::cart');
$routes->get('/productdetail', 'HomeController::productdetail');
$routes->get('/ordersukses', 'HomeController::ordersukses');

// Checkout Routes
$routes->get('/checkout', 'CheckoutController::index');
$routes->post('/checkout/process', 'CheckoutController::process');
$routes->post('/checkout/complete', 'CheckoutController::complete');
$routes->get('/myorder', 'CheckoutController::myOrders');
$routes->post('/checkout/update-status/(:num)/(:alpha)', 'CheckoutController::updateStatus/$1/$2');

// Payment Routes
$routes->get('/payment', 'PaymentController::index');

// User Profile Routes
$routes->get('/profile', 'UserController::userprofile');
$routes->post('/user/updateProfile', 'UserController::updateProfile');
$routes->post('/user/updatePhoto', 'UserController::updatePhoto');

// Authentication Routes
$routes->get('/login', 'AuthController::login');
$routes->get('/register', 'AuthController::register');

// Restrict access for Admin Dashboard Routes
$routes->get('/dashboard', 'Admin\DashboardController::index', ['filter' => 'role:admin']);
$routes->get('/admin', 'Admin\DashboardController::index', ['filter' => 'role:admin']);

// Admin Produk Routes with Role Admin Access
$routes->group('admin/produk', ['namespace' => 'App\Controllers\Admin', 'filter' => 'role:admin'], function ($routes) {
    $routes->get('/', 'ProdukController::index');
    $routes->get('detail/(:num)', 'ProdukController::detail/$1');
    $routes->get('edit/(:num)', 'ProdukController::edit/$1');
    $routes->post('update/(:num)', 'ProdukController::update/$1');
    $routes->get('delete/(:num)', 'ProdukController::delete/$1');
    $routes->get('tambah', 'ProdukController::tambah');
    $routes->post('save', 'ProdukController::save');
    $routes->get('export-excel', 'ProdukController::exportExcel');
    $routes->get('export-csv', 'ProdukController::exportCSV');
    $routes->get('export-pdf', 'ProdukController::exportPDF');
});

// Admin Kategori Routes with Role Admin Access
$routes->group('admin/kategori', ['namespace' => 'App\Controllers\Admin', 'filter' => 'role:admin'], function ($routes) {
    $routes->get('/', 'KategoriController::index');
    $routes->get('create', 'KategoriController::create');
    $routes->post('store', 'KategoriController::store');
    $routes->get('edit/(:num)', 'KategoriController::edit/$1');
    $routes->post('update/(:num)', 'KategoriController::update/$1');
    $routes->get('delete/(:num)', 'KategoriController::delete/$1');
});

// Admin Transaksi Routes with Role Admin Access
$routes->group('admin/transaksi', ['namespace' => 'App\Controllers\Admin', 'filter' => 'role:admin'], function ($routes) {
    $routes->get('/', 'TransaksiController::index');
    $routes->get('detail/(:num)', 'TransaksiController::detail/$1');
    $routes->post('ship/(:num)', 'TransaksiController::ship/$1');
    $routes->get('export-excel', 'TransaksiController::exportExcel');
    $routes->get('export-csv', 'TransaksiController::exportCSV');
    $routes->get('export-pdf', 'TransaksiController::exportPDF');
});

// Admin Metadata Routes with Role Admin Access
$routes->post('admin/metadata/delete/(:num)', 'Admin\MetadataController::delete/$1', ['filter' => 'role:admin']);

// Produk Routes
$routes->get('/produk', 'ControllerProduk::index');
$routes->get('/produk/(:segment)', 'HomePageController::produkDetail/$1');
$routes->get('/category', 'ControllerProduk::index');

// Homepage Routes
$routes->group('homepage', function ($routes) {
    $routes->get('/', 'HomePageController::index');
    $routes->get('cek', 'HomePageController::cek');
    $routes->post('add', 'HomePageController::add');
    $routes->post('update', 'HomePageController::update');
    $routes->get('clear', 'HomePageController::clear');
    $routes->get('cart', 'HomePageController::cart');
    $routes->get('remove/(:any)', 'HomePageController::remove/$1');
});
