<?php

$routes->group(getenv('route.groupManage') . 'bidangProgram', ['filter' => 'AuthFilter'], static function ($routes) {
    foreach (['index', 'show', 'store'] as $key => $value) {
        $routes->add((($value != 'index') ? $value : ''), "\BackEnd\BidangProgram\Controllers\BidangProgramController::{$value}");
    }
});
