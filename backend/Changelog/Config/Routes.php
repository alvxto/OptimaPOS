<?php

$routes->group(getenv('route.groupManage').'changelog', ['filter' => 'AuthFilter'], static function ($routes) {
    foreach (['index', 'show', 'store', 'update', 'destroy', 'getData'] as $key => $value) {
        $routes->add((($value != 'index') ? $value : '') , "\BackEnd\Changelog\Controllers\ChangelogController::{$value}");
    }
});