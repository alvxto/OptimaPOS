<?php

$routes->group(getenv('route.groupManage') . 'dokumen', ['filter' => 'AuthFilter'], static function ($routes) {
    foreach (['index', 'show', 'getData', 'getDataDropdown', 'getFilter', 'getCombo'] as $key => $value) {
        $routes->add((($value != 'index') ? $value : ''), "\BackEnd\Dokumen\Controllers\DokumenController::{$value}");
    }
});
