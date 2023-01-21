<?php

$routes->group(getenv('route.groupManage') . 'profile', ['filter' => 'AuthFilter'], static function ($routes) {
    foreach (['index', 'show', 'showChangeLog', 'update', 'changePassword'] as $key => $value) {
        $routes->add((($value != 'index') ? $value : ''), "\BackEnd\Profile\Controllers\ProfileController::{$value}");
    }
});
