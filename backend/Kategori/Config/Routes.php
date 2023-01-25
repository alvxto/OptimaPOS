<?php

$routes->group(getenv('route.groupManage').'kategori', ['filter' => 'AuthFilter'], static function ($routes) {
    foreach (['index', 'show', 'store', 'update', 'destroy'] as $key => $value) {
        $routes->add((($value != 'index') ? $value : '') , "\BackEnd\kategori\Controllers\kategoriController::{$value}");
    }
});