<?php

$routes->group(getenv('route.groupManage') . 'pengaduan', ['filter' => 'AuthFilter'], static function ($routes) {
    foreach (['index'] as $key => $value) {
        $routes->add((($value != 'index') ? $value : ''), "\BackEnd\Pengaduan\Controllers\PengaduanController::{$value}");
    }
});
