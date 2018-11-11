<?php

use Illuminate\Routing\Router;
use Illuminate\Http\Request;


Admin::registerAuthRoutes();
Route::middleware('auth:api')->get('user', function (Request $request) {
    return $request->user();
});
Route::get('parameters', function (Request $request) {
    return $request->all();
});
Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('news', 'NewsController');
    $router->resource('enroll', 'EnrollController');
    $router->resource('join', 'JoinController');
    $router->resource('shequ', 'ShequController');
});
