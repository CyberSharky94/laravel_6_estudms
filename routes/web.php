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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Level Controller Routes
Route::resource('level','LevelController')->middleware('auth');

// Role Controller Routes
Route::resource('role','RoleController')->middleware('auth');

// Student Controller Routes
Route::resource('student','StudentController')->middleware('auth');
Route::post('/student/ajax_get_class_list', 'StudentController@ajaxGetClassList')->middleware('auth')->name('student.ajax_get_class_list');
Route::post('/student/ajax_show', 'StudentController@ajax_show')->middleware('auth')->name('student.ajax_show');

// Class Controller Routes
Route::resource('class','ClassController')->middleware('auth');

// Test Controller Routes
Route::get('/test', 'TestController@index')->name('test.index');
Route::get('test/export_pdf', 'TestController@export_pdf')->name('test.export_pdf');
Route::get('test/export_excel', 'TestController@export_excel')->name('test.export_excel');
Route::get('test/send_email', 'TestController@send_email')->name('test.send_email');