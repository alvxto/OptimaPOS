<?php

$routes->group('test', static function ($routes) {
	foreach ([
			'nanoid',
			'find',
			'findAll',
			'store',
			'update',
			'destroy',
			'trans',
			// 'table'
		] as $key => $value) {
        $routes->add((($value == 'index') ? '/' : $value), "\BackEnd\Test\Controllers\TestController::{$value}");
    }
    $routes->post('table', "\BackEnd\Test\Controllers\TestController::table");
});