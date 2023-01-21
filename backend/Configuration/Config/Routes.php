<?php

$routes->group(getenv('route.groupManage').'config', ['filter' => 'AuthFilter'], static function ($routes) {
    foreach (['getConfig','save','uploadFile','deleteFile'] as $key => $value) {
        $routes->add($value, "\BackEnd\Configuration\Controllers\ConfigurationController::{$value}");
    }
    $routes->get('getImage/(:any)', "\BackEnd\Configuration\Controllers\ConfigurationController::getImage/$1");
});
