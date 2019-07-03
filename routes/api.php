<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1',[
    'namespace'=>'App\Http\Controllers\Api',
    'middleware'=>['serializer:array','cors']
],function ($api){
    $api->get('connection','ConnectionController@connection');
    $api->post('bind','ConnectionController@bind');

    $api->get('modules','ModulesController@index');

    $api->post('users','UsersController@store')
        ->name('api.users.store');

    $api->post('authorizations', 'AuthorizationsController@store')
        ->name('api.authorizations.store');

    // 刷新token
    $api->put('authorizations/current', 'AuthorizationsController@update')
        ->name('api.authorizations.update');
    // 删除token
    $api->delete('authorizations/current', 'AuthorizationsController@destroy')
        ->name('api.authorizations.destroy');
});
