<?php

$routes->group(getenv('route.groupManage') . 'pekerjaan', ['filter' => 'AuthFilter'], static function ($routes) {
    foreach (['index', 'show', 'store', 'update', 'destroy', 'getData', 'getPejabat', 'generateDoc', 'uploadDoc', 'newTermyn'] as $key => $value) {
        $routes->add((($value != 'index') ? $value : ''), "\BackEnd\Pekerjaan\Controllers\PekerjaanController::{$value}");
    }
});
