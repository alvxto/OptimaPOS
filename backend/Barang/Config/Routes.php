<?php

$routes->group(getenv('route.groupManage').'barang', ['filter' => 'AuthFilter'], static function ($routes) {
    foreach (['index', 'show', 'store', 'update', 'destroy', 'getData'] as $key => $value) {
        $routes->add((($value != 'index') ? $value : '') , "\BackEnd\barang\Controllers\barangController::{$value}");
    }
});