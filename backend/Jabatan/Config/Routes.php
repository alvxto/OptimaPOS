<?php

$routes->group(getenv('route.groupManage').'jabatan', ['filter' => 'AuthFilter'], static function ($routes) {
    foreach (['index', 'show', 'store', 'update', 'destroy'] as $key => $value) {
        $routes->add((($value != 'index') ? $value : '') , "\BackEnd\Jabatan\Controllers\JabatanController::{$value}");
    }
});