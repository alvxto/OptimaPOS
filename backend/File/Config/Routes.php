<?php

$routes->group(getenv('route.groupManage') . 'file', ['filter' => 'AuthFilter'], static function ($routes) {
    $routes->add('(:any)', "\BackEnd\File\Controllers\FileController::index::/$1");
});

$routes->add('file/logo', "\BackEnd\File\Controllers\FileController::logo");
$routes->add('file/background', "\BackEnd\File\Controllers\FileController::background");
