<?php

$routes->group('members', ['namespace' => 'Myth\Users\Controllers'], function($routes) {
    $routes->get('(:segment)', 'UserController::show/$1');
});
