<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api\V1',
], function ($api) {
    $api->post('/register', 'AuthController@register');
    $api->post('/login', 'AuthController@login');
    $api->get('/me', 'AuthController@me');
    $api->get('/refresh', 'AuthController@refresh');

    $api->post('/storage', 'StorageController@index');

    $api->get('/mentor/favorite', 'MentorController@favorite');
    $api->get('/schedule', 'ScheduleController@index');

    $api->get('/activity', 'ActivityController@main');
});
