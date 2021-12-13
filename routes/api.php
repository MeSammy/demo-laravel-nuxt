<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TMDBController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'auth',
    'namespace' => 'App\Http\Controllers'
], function ($router) {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('refresh', 'AuthController@refresh');
});

Route::group([
    'middleware' => 'jwt.auth',
    'namespace' => 'App\Http\Controllers'
], function () {
    Route::get('me', 'MeController@index');
    Route::post('auth/logout', 'MeController@logout');
});


Route::get('getMovies', [TMDBController::class, 'getMovies']);
Route::get('getMoviesByQuery', [TMDBController::class, 'getMoviesByQuery']);
Route::get('getMoviesById', [TMDBController::class, 'getMoviesById']);
