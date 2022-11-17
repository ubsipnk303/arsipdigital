<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->group('login', ['filter'=>'ceklogin'],  function(RouteCollection $routes){
    $routes->get('lupa', 'PenggunaController::viewLupaPassword');
    $routes->get('/', 'PenggunaController::viewLogin');
    $routes->post('/', 'PenggunaController::login');
    $routes->patch('/', 'PenggunaController::lupaPassword');
});

$routes->delete('login', 'PenggunaController::logout');

$routes->group('pengguna', ['filter'=> 'otentikasi' ], function(RouteCollection $routes){
    $routes->get('/', 'PenggunaController::index');
    $routes->post('/', 'PenggunaController::store');
    $routes->patch('/', 'PenggunaController::update');
    $routes->delete('/', 'PenggunaController::delete');
    $routes->get('(:num)', 'PenggunaController::show/$1');
    $routes->get('all', 'PenggunaController::all');
    
});

$routes->group('arsip', ['filter'=> 'otentikasi' ], function(RouteCollection $routes){
    $routes->get('/', 'ArsipController::index');
    $routes->post('/', 'ArsipController::store');
    $routes->patch('/', 'ArsipController::update');
    $routes->delete('/', 'ArsipController::delete');
    $routes->get('(:num)', 'ArsipController::show/$1');
    $routes->get('all', 'ArsipController::all');
    
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
