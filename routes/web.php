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

Route::get('/home', 'HomeController@main')->name('home');

Route::get('/UnauditedDataList1', 'UnauditedDataList1Controller@main')->name('UnauditedDataList1');

Route::any('/AuditClient', 'AuditClientController@index')->name('AuditClient');

Route::any('/audit1', 'AuditClientController@audit1')->name('audit1');
