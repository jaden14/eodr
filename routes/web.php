<?php

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
	if(Auth::check()) {

    	return redirect('accomplishment');
    } else {
        return view('auth.login');
    }
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/accomplishment', 'AccomplishmentController');
Route::post('/accomplishment/acc_edit', 'AccomplishmentController@acc_edit')->name('accedit');
Route::post('/accomplishment/acc_update', 'AccomplishmentController@acc_update')->name('accupdate');
Route::post('/accomplishment/acc_delete', 'AccomplishmentController@acc_delete')->name('accdelete');
Route::get('/accomplishment_searchs', 'AccomplishmentController@searchs')->name('searchs');


Route::resource('/employees', 'UserController');
Route::post('/employees/user_edit', 'UserController@user_edit')->name('useredit');
Route::post('/employees/user_update', 'UserController@user_update')->name('userupdate');
Route::post('/employees/user_delete', 'UserController@user_delete')->name('userdelete');
Route::get('/employees_search', 'UserController@search')->name('search');


