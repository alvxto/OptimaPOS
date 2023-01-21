<?php

$routes->group(getenv('route.groupManage').'pejabat', ['filter' => 'AuthFilter'], static function ($routes) {
    foreach (['index', 'show', 'store', 'update', 'destroy', 'getData'] as $key => $value) {
        $routes->add((($value != 'index') ? $value : '') , "\BackEnd\Pejabat\Controllers\PejabatController::{$value}");
    }
});