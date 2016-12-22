<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
 */

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group(['prefix' => 'user'], function () use ($app) {
    $app->get('/', 'UserController@index');
    $app->post('/add', 'UserController@create');
    $app->get('/{id}', 'UserController@show');
});

$app->group(['prefix' => 'changeLog'], function () use ($app) {
    $app->get('/', 'ChangeLogController@index');
    $app->get('/findByParking/{id}', 'ChangeLogController@findByParking');
    $app->get('/findByChanger/{id}', 'ChangeLogController@findByChanger');
});

$app->group(['prefix' => 'parkingLot'], function () use ($app) {
    $app->get('/', 'ParkingLotController@index');
    $app->post('/add', 'ParkingLotController@create');
    $app->get('/{id}', 'ParkingLotController@show');
});
