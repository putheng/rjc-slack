<?php

use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/slack/hook', 'SlackControler@index');
Route::post('/slack/request/leave', 'RequestLeaveController@index');

Route::get('/slack/approval/form', 'ApprovalController@index')->name('form.approval');
Route::post('/slack/approval/form', 'ApprovalController@store');

Route::get('/slack/approval/form/{approval}', 'ApprovalController@view');

Route::post('/slac/approval/request', 'ApprovalController@request')->name('approval.request');

Route::group(['prefix' => 'slack', 'as' => 'slack.', 'middleware' => 'auth'], function(){
    
    Route::get('show', 'SlackControler@show');
    
    Route::get('filter', 'SlackControler@filter')->name('filter');
    
    Route::post('/filter', 'SlackControler@exportCsv')->name('filter.export');
    
});

Route::get('video', 'Courses\CourseController@index');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
