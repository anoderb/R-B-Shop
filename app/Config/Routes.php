<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'HomeController::index');
// $routes->get('/home', 'HomeController::index');
$routes->get('/cart', 'HomeController::cart');
// $routes->get('/category', 'HomeController::category');
$routes->get('/productdetail', 'HomeController::productdetail');
// $routes->get('/checkout', 'HomeController::checkout');
$routes->get('/ordersukses', 'HomeController::ordersukses');

$routes->get('/myorder', 'CheckoutController::myOrders');
$routes->post('/checkout/update-status/(:num)/(:alpha)', 'CheckoutController::updateStatus/$1/$2');


$routes->get('/checkout', 'CheckoutController::index');
$routes->post('/checkout/process', 'CheckoutController::process');
$routes->post('/checkout/complete', 'CheckoutController::complete');

$routes->get('/payment', 'PaymentController::index');



$routes->get('/profile', 'UserController::userprofile');
$routes->post('/user/update', 'UserController::update');
$routes->get('/user/update', 'UserController::update');
$routes->post('/user/updateProfile', 'UserController::updateProfile');
$routes->post('/user/updatePhoto', 'UserController::updatePhoto');





$routes->get('/login', 'AuthController::login');
$routes->get('/register', 'AuthController::register');
$routes->get('/dashboard', 'Admin\DashboardController::index');


$routes->get('/admin', 'Admin\DashboardController::index', ['filter' => 'role:admin']);
$routes->get('/home', 'HomeController::index', ['filter' => 'role:user']);



$routes->get('admin/produk', 'Admin\ProdukController::index');
$routes->get('admin/produk/detail/(:num)', 'Admin\ProdukController::detail/$1');
$routes->get('admin/produk/edit/(:num)', 'Admin\ProdukController::edit/$1');
$routes->get('admin/produk/delete/(:num)', 'Admin\ProdukController::delete/$1');
$routes->get('admin/produk/tambah', 'Admin\ProdukController::tambah');
$routes->post('admin/produk/save', 'Admin\ProdukController::save');
$routes->get('admin/produk/edit/(:num)', 'Admin\ProdukController::edit/$1');
$routes->post('admin/produk/update/(:num)', 'Admin\ProdukController::update/$1');

$routes->group('admin/kategori', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->get('/', 'KategoriController::index');
    $routes->get('create', 'KategoriController::create');
    $routes->post('store', 'KategoriController::store');
    $routes->get('edit/(:num)', 'KategoriController::edit/$1');
    $routes->post('update/(:num)', 'KategoriController::update/$1');
    $routes->get('delete/(:num)', 'KategoriController::delete/$1');
});


$routes->get('/admin/transaksi', 'Admin\TransaksiController::index');

$routes->get('/category', 'ControllerProduk::index');


$routes->post('admin/metadata/delete/(:num)', 'Admin\MetadataController::delete/$1');

// routes.php
$routes->get('/produk', 'ControllerProduk::index');
// $routes->get('/produk/(:segment)', 'ControllerProduk::detail/$1');
$routes->get('/produk/(:segment)', 'HomePageController::produkDetail/$1');





$routes->get('/homepage', 'HomePageController::index');
$routes->get('/homepage/cek', 'HomePageController::cek');
$routes->post('/homepage/add', 'HomePageController::add');
$routes->post('/homepage/update', 'HomePageController::update');
$routes->get('/homepage/clear', 'HomePageController::clear');


$routes->get('/homepage/cart', 'HomePageController::cart');
$routes->get('homepage/remove/(:any)', 'HomePageController::remove/$1');


$routes->get('admin/produk/export-excel', 'Admin\ProdukController::exportExcel');
$routes->get('admin/produk/export-csv', 'Admin\ProdukController::exportCSV');
$routes->get('admin/produk/export-pdf', 'Admin\ProdukController::exportPDF');

$routes->get('admin/transaksi/export-excel', 'Admin\TransaksiController::exportExcel');
$routes->get('admin/transaksi/export-csv', 'Admin\TransaksiController::exportCSV');
$routes->get('admin/transaksi/export-pdf', 'Admin\TransaksiController::exportPDF');



$routes->get('admin/transaksi/detail/(:num)', 'Admin\TransaksiController::detail/$1');





