<?php

use Illuminate\Support\Facades\Auth;
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

/*
 * W pliku web.php określamy
 *
 */

//Wywołanie
Auth::routes(['register' => false]);

Route::get('/', 'Auth\LoginController@showLoginForm');

Route::get('/home', 'HomeController@index');

Route::middleware(['auth'])->group(function() {

    Route::middleware(['work.started'])->group(function() {
        Route::middleware(['operation.started'])->group(function() {
            Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:manage-user')->group(function(){
                Route::resource('/users', 'UsersController', ['except' => ['show']]);
            });
            Route::get('/users', 'Admin\UsersController@show')->name('users.show');

            Route::namespace('WorkRecord')->prefix('ewidencja')->name('ewidencja.')->middleware(['auth'])->group(function(){
                Route::resource('praca', 'WorkRecordsController', ['except' => ['create', 'startWork']]);
                Route::resource('elementy', 'ProductRecordsController', ['except' => ['update']]);
                Route::post('elementy/pobierz-operacje', 'ProductRecordsController@getSelectedProductOperations')->name('elementy.get.product.operations');
            });

            Route::put('praca/praca-koniec', 'WorkRecord\WorkRecordsController@handleWorkRecord')->name('ewidencja.praca.end');

            Route::resource('product', 'Operations\ProductsController');
            Route::resource('operation', 'Operations\OperationsController');
            Route::resource('product-operations', 'Operations\ProductOperationsController');
        });
        Route::match(['put', 'patch'], 'ewidencja/elementy/{elementy}', 'WorkRecord\ProductRecordsController@update')->name('ewidencja.elementy.update');
    });

    Route::get('praca/rozpocznij-prace', 'WorkRecord\WorkRecordsController@create')->name('ewidencja.praca.create')->middleware(['operation.started']);
    Route::put('praca/praca-start', 'WorkRecord\WorkRecordsController@handleWorkRecord')->name('ewidencja.praca.start')->middleware(['operation.started']);
});


