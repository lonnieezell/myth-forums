<?php

$routes->group('forum', ['namespace' => 'Myth\Forums\Controllers'], function($routes) {
    $routes->get('/', 'ForumController::list');

    $routes->get('new-topic', 'ForumController::newTopic', ['as' => 'new_topic', 'filter' => 'permission:post']);
    $routes->post('new-topic', 'ForumController::saveNewTopic', ['filter' => 'permission:post']);

    $routes->get('discussion/(:segment)', 'ForumController::showTopic/$1', ['as' => 'topic']);
    $routes->post('discussion/(:segment)/reply', 'ForumController::postReply/$1', ['as' => 'post-reply']);
});

$routes->group('admin/forum', ['namespace' => 'Myth\Forums\Controllers\Admin'], function($routes) {
    $routes->get('/', 'ForumController::index', ['as' => 'forum-admin']);
    $routes->get('tags', 'TagController::list', ['as' => 'forum-admin-tags']);
});
