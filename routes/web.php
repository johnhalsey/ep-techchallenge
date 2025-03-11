<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['prefix' => 'clients'], function () {
        Route::get('/', 'ClientsController@index')->name('clients.index');
        Route::get('/create', 'ClientsController@create');
        Route::post('/', 'ClientsController@store');

        Route::group(['prefix' => '/{client}', 'middleware' => 'can:manage,client'], function () {
            Route::get('/', 'ClientsController@show');
            Route::delete('/', 'ClientsController@destroy')->name('clients.destroy');

            Route::get('/journals/create', 'JournalsController@create');
            Route::post('/journals', 'JournalsController@store')->name('clients.journals.store');
            Route::delete('/journals/{journal}', 'JournalsController@destroy')->name('clients.journals.destroy');;
        });
    });
});


