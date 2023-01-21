<?php

$routes->group(getenv('route.groupManage').'position', ['filter' => 'AuthFilter'], static function ($routes) {
    foreach (['index', 'show', 'store', 'update', 'destroy'] as $key => $value) {
        $routes->add((($value != 'index') ? $value : '') , "\BackEnd\Position\Controllers\PositionController::{$value}");
    }
});