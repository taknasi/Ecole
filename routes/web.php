<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {

    
    Route::group(['middleware' => 'auth'], function () {

        /******************************** Dashboard ******************************************/
        Route::get('/', function () {
            return view('dashboard');
        });
        /******************************** End Dashboard **************************************/
        Route::get('/lol', function () {
            return view('dashboardf');
        });
    });

    /******************************** Login and register *************************************/
    Auth::routes(['register'=>false]);
    Route::get('/logout', 'Auth\LoginController@logout'); // put logout in link 
    /******************************** End Login and register *********************************/
});
