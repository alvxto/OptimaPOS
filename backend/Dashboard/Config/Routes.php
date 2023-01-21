<?php

$routes->group(getenv('route.groupManage') . 'dashboard', ['filter' => 'AuthFilter'], static function ($routes) {
	foreach (['index','getData'] as $key => $value) {
         $routes->add((($value != 'index') ? $value : ''), "\BackEnd\Dashboard\Controllers\DashboardController::{$value}");
    }
});