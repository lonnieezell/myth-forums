<?php

$routes->group('forum', ['namespace' => 'Myth\Forums\Controllers'], function($routes) {
    $routes->get('/', 'ForumController::list');

    $routes->get('new-topic', 'ForumController::newTopic', ['as' => 'new_topic', 'filter' => 'permission:post']);
    $routes->post('new-topic', 'ForumController::saveNewTopic', ['filter' => 'permission:post']);

    $routes->get('discussion/(:segment)', 'ForumController::showTopic/$1');
});
