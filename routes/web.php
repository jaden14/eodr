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

Route::get('/supervisor_login', function () {
	
        return view('welcome');
});

Auth::routes();

Route::get('home', [HomeController::class, 'index'])->name('home');
Route::post('login/verify','HomeController@verify')->name('login.verify');

Route::resource('/accomplishment', 'AccomplishmentController');
Route::post('/accomplishment/acc_edit', 'AccomplishmentController@acc_edit')->name('accedit');
Route::post('/accomplishment/acc_update', 'AccomplishmentController@acc_update')->name('accupdate');
Route::post('/accomplishment/acc_delete', 'AccomplishmentController@acc_delete')->name('accdelete');
Route::get('/accomplishment_searchs', 'AccomplishmentController@searchs')->name('searchs');
Route::get('/accomplishment_division','AccomplishmentController@accomplishment_division');


Route::resource('/employees', 'UserController');
Route::post('/employees/user_edit', 'UserController@user_edit')->name('useredit');
Route::post('/employees/user_update', 'UserController@user_update')->name('userupdate');
Route::post('/employees/user_delete', 'UserController@user_delete')->name('userdelete');
Route::get('/employees_search', 'UserController@search')->name('search');
Route::get('/employees_division','UserController@employees_division');


Route::resource('/offices', 'OfficeController');
Route::post('/offices/office_edit', 'OfficeController@office_edit')->name('officeedit');
Route::post('/offices/office_update', 'OfficeController@office_update')->name('officeupdate');
Route::post('/offices/office_delete', 'OfficeController@office_delete')->name('officedelete');
Route::get('/offices_search', 'OfficeController@office_search')->name('officesearch');


Route::resource('/division', 'DivisionController');
Route::post('/division/division_edit', 'DivisionController@division_edit')->name('divisionedit');
Route::post('/division/division_update', 'DivisionController@division_update')->name('divisionupdate');
Route::post('/division/division_delete', 'DivisionController@division_delete')->name('divisiondelete');
Route::get('/division_search', 'DivisionController@division_search')->name('divisionsearch');

Route::resource('/Supervisor', 'SupervisorController');


