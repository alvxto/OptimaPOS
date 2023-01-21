<?php

$routes->group(getenv('route.groupManage') . 'laporan', ['filter' => 'AuthFilter'], static function ($routes) {
    foreach (['index', 'show', 'getData', 'getExcel', 'getCombo'] as $key => $value) {
        $routes->add((($value != 'index') ? $value : ''), "\BackEnd\Laporan\Controllers\LaporanController::{$value}");
    }
});
