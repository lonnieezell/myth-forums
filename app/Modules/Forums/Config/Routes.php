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
    $routes->get('tags/new', 'TagController::create', ['as' => 'forum-admin-new-tag']);
    $routes->get('tags/(:segment)', 'TagController::edit/$1', ['as' => 'forum-admin-edit-tag']);
    $routes->post('tags/', 'TagController::save', ['as' => 'forum-admin-save-tag']);
    $routes->post('tags/(:segment)', 'TagController::save/$1', ['as' => 'forum-admin-update-tag']);
});
