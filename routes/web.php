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

Route::get('/UnauditedList1', 'UnauditedList1Controller@main')->name('UnauditedList1');

Route::get('/UnauditedList2', 'UnauditedList2Controller@main')->name('UnauditedList2');

Route::get('/RejectedList1', 'RejectedList1Controller@main')->name('RejectedList1');

Route::get('/ReauditList1', 'ReauditList1Controller@main')->name('ReauditList1');

Route::any('/AuditClient', 'AuditClientController@index')->name('AuditClient');

Route::any('/audit1', 'AuditClientController@audit1')->name('audit1');

Route::any('/DeliverableList2', 'DeliverableList2Controller@main')->name('DeliverableList2');

Route::any('/GenerateAyersAccount', 'AyersAccountController@generate')->name('GenerateAyersAccount');

Route::any('/generateQRCode', 'AEController@generateQRCode')->name('generateQRCode');

Route::any('/QRCode', 'AEController@QRCode')->name('QRCode');
