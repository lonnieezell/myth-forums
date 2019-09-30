<?php

$routes->group('users', ['namespace' => 'Myth\Users\Controllers'], function($routes) {
    $routes->get('(:segment)', 'UserController::show/$1');
});
