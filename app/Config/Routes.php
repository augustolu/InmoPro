<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');
$routes->get('/propiedades', 'Propiedades::index');
$routes->get('/propiedades/detalle/(:num)', 'Propiedades::detalle/$1');
$routes->get('auth/login', 'AuthController::login');
$routes->post('/auth/processLogin', 'AuthController::processLogin');
$routes->get('auth/register', 'AuthController::register');
$routes->post('/auth/processRegister', 'AuthController::processRegister');
$routes->get('auth/logout', 'AuthController::logout');

// Rutas de Reservas
$routes->get('/reservas', 'Reservas::disponibilidad');
$routes->get('/reservas/disponibilidad', 'Reservas::disponibilidad');
$routes->get('/reservas/reservar/(:num)', 'Reservas::reservar/$1');
$routes->post('/reservas/confirmar', 'Reservas::confirmar');
$routes->get('/reservas/disponibilidad-propiedad/(:num)', 'Reservas::disponibilidadPropiedad/$1');
$routes->get('/reservas/reservar-propiedad/(:num)', 'Reservas::reservarPropiedad/$1');
$routes->post('/reservas/confirmar-propiedad', 'Reservas::confirmarReservaPropiedad');



// Rutas protegidas por login
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/perfil', 'Usuario::perfil');
    $routes->get('/mis-reservas', 'Reservas::misReservas');
    $routes->get('/mis-reservas-propiedades', 'Reservas::misReservasPropiedades');
});

// Rutas solo para administradores
$routes->group('admin', ['filter' => 'auth:admin'], function($routes) {
    $routes->get('dashboard', 'Admin::dashboard');
    $routes->get('usuarios', 'Admin::usuarios');
    $routes->get('habitaciones', 'Admin::habitaciones');
    
    // Gestión de Propiedades
    $routes->get('propiedades/agregar', 'Admin::agregarPropiedad');
    $routes->post('propiedades/guardar', 'Admin::guardarPropiedad');
    
    // Gestión de Imágenes de Propiedades
    $routes->get('imagenes/(:num)', 'Admin::agregarImagenesPropiedad/$1');
    $routes->post('imagenes/guardar/(:num)', 'Admin::guardarImagenesPropiedad/$1');
    $routes->get('imagenes/eliminar/(:num)/(:num)', 'Admin::eliminarImagenPropiedad/$1/$2');
});