<?php

$routes->group(getenv('route.groupManage').'program', ['filter' => 'AuthFilter'], static function ($routes) {
    foreach (['index', 'show', 'store', 'update', 'destroy'] as $key => $value) {
        $routes->add((($value != 'index') ? $value : '') , "\BackEnd\Program\Controllers\ProgramController::{$value}");
    }
});