<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    if (file_exists('index.html')) {

        // get raw file data
        $raw_file_data = file_get_contents('index.html');

        return $raw_file_data;

    } else {

        // 404
        return 'SSS' . $router->app->version();

    }
    //return view("index.html"); // 
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('checkpoints', ['uses' => 'CheckPointController@getCheckpoints']);
    $router->get('checkpoints/protocol', ['uses' => 'CheckPointController@protocol']);
    $router->get('checkpoints/{id}', ['uses' => 'CheckPointController@showOne']);
    $router->post('checkpoints', ['uses' => 'CheckPointController@create']);
    $router->delete('checkpoints/{id}', ['uses' => 'CheckPointController@delete']);
    $router->put('checkpoints/{id}', ['uses' => 'CheckPointController@update']);

    $router->get('athletes', ['uses' => 'AthleteController@showAll']);
    $router->get('athletes/{id}', ['uses' => 'AthleteController@showOne']);
    $router->post('athletes', ['uses' => 'AthleteController@create']);
    $router->delete('athletes/{id}', ['uses' => 'AthleteController@delete']);
    $router->put('athletes/{id}', ['uses' => 'AthleteController@update']);

    $router->get('groups', ['uses' => 'GroupController@showAll']);
    $router->get('groups/{id}', ['uses' => 'GroupController@showOne']);
    $router->post('groups', ['uses' => 'GroupController@create']);
    $router->delete('groups/{id}', ['uses' => 'GroupController@delete']);
    $router->put('groups/{id}', ['uses' => 'GroupController@update']);

});
