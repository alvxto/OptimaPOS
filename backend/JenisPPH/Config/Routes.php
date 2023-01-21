<?php

$routes->group(getenv('route.groupManage').'jenispph', ['filter' => 'AuthFilter'], static function ($routes) {
    foreach (['index', 'show', 'store', 'update', 'destroy'] as $key => $value) {
        $routes->add((($value != 'index') ? $value : '') , "\BackEnd\JenisPPH\Controllers\JenisPPHController::{$value}");
    }
});