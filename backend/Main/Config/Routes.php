<?php
    
$routes->get('main', '\BackEnd\Main\Controllers\MainController::index' , ['filter' => 'AuthFilter'] );

$routes->group(getenv('route.groupManage').'main', ['filter' => 'AuthFilter'], static function ($routes) {
    foreach (['getPage'] as $key => $value) {
        $routes->add($value, "\BackEnd\Main\Controllers\MainController::{$value}");
    }
});