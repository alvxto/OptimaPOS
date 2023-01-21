<?php

$routes->group(getenv('route.groupManage').'hak-access', ['filter' => 'AuthFilter'], static function ($routes) {
    foreach (['getRoleList','getMenuList','saveRole', 'destroyRole','save','editRole'] as $key => $value) {
        $routes->add((($value != 'index') ? $value : '') , "\BackEnd\HakAccess\Controllers\HakAccessController::{$value}");
    }
});
