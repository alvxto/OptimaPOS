<?php

$routes->group(getenv('route.groupManage').'kegiatansub', ['filter' => 'AuthFilter'], static function ($routes) {
    foreach (['index', 'show', 'store', 'update', 'destroy', 'getData'] as $key => $value) {
        $routes->add((($value != 'index') ? $value : '') , "\BackEnd\KegiatanSub\Controllers\KegiatanSubController::{$value}");
    }
});