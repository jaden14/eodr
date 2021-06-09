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
        return view('welcome');
    }
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

Route::resource('/targets', 'TargetController');
Route::post('/targets/target_edit', 'TargetController@target_edit')->name('targetedit');
Route::post('/targets/target_update', 'TargetController@target_update')->name('targetupdate');
Route::post('/targets/target_delete', 'TargetController@target_delete')->name('targetdelete');

Route::resource('/journal', 'JournalController');
Route::post('/journal/journal_edit', 'JournalController@journal_edit')->name('journaledit');
Route::post('/journal/journal_update', 'JournalController@journal_update')->name('journalupdate');
Route::post('/journal/journal_delete', 'JournalController@journal_delete')->name('journaldelete');
Route::get('/journal_searchs', 'JournalController@searchsss')->name('searchsss');

Route::resource('/committe', 'CommitteeController');
Route::post('/committe/committe_add', 'CommitteeController@committe_add')->name('committeadd');
Route::post('/committe/committe_edit', 'CommitteeController@committe_edit')->name('committeedit');
Route::post('/committe/committe_editperson', 'CommitteeController@committe_editperson')->name('committeeditperson');
Route::post('/committe/committe_updateperson', 'CommitteeController@committe_updateperson')->name('committeupdateperson');
Route::post('/committe/committe_update', 'CommitteeController@committe_update')->name('committeupdate');
Route::post('/committe/committe_delete', 'CommitteeController@committe_delete')->name('committedelete');
Route::post('/committe/member_delete', 'CommitteeController@member_delete')->name('memberdelete');

Route::resource('/meeting', 'MeetingController');
Route::post('/meeting/meeting_edit', 'MeetingController@meeting_edit')->name('meetingedit');
Route::post('/meeting/meeting_update', 'MeetingController@meeting_update')->name('meetingupdate');
Route::post('/meeting/meeting_delete', 'MeetingController@meeting_delete')->name('meetingdelete');



Route::resource('/export', 'ExportController');
Route::get('/exports', 'ExportController@export');

