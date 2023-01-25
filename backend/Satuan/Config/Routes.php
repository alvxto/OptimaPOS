<?php

$routes->group(getenv('route.groupManage').'satuan', ['filter' => 'AuthFilter'], static function ($routes) {
    foreach (['index', 'show', 'store', 'update', 'destroy'] as $key => $value) {
        $routes->add((($value != 'index') ? $value : '') , "\BackEnd\satuan\Controllers\satuanController::{$value}");
    }
});