<?php

$routes->group(getenv('route.groupManage').'sumberdana', ['filter' => 'AuthFilter'], static function ($routes) {
    foreach (['index', 'show', 'store', 'update', 'destroy'] as $key => $value) {
        $routes->add((($value != 'index') ? $value : '') , "\BackEnd\SumberDana\Controllers\SumberDanaController::{$value}");
    }
});