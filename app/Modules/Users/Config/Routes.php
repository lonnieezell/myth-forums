<?php

$routes->get('account', 'Myth\Users\Controllers\AccountController::index', ['as' => 'account']);

$routes->group('members', ['namespace' => 'Myth\Users\Controllers'], function($routes) {
    $routes->get('(:segment)', 'UserController::show/$1');
});
