<?php

$routes->add('/', "\BackEnd\Login\Controllers\LoginController::index");

$routes->group('app-login', static function ($routes) {
    foreach (['index', 'login', 'forgot', 'sendForgot', 'changePassword'] as $key => $value) {
        $routes->add((($value == 'index') ? '/' : $value), "\BackEnd\Login\Controllers\LoginController::{$value}");
    }
    $routes->get('change/(:any)', "\BackEnd\Login\Controllers\LoginController::change/$1");
});

$routes->group(getenv('route.groupManage') . 'login', ['filter' => 'AuthFilter'], static function ($routes) {
    $routes->add('logout', "\BackEnd\Login\Controllers\LoginController::logout");
});
