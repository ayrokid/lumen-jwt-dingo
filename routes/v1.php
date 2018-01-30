<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api\V1',
], function ($api) {

    $api->post('/login', 'AuthController@login');

    $api->get('/me', 'AuthController@me');

});
