<?php

use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/slack/hook', 'SlackControler@index');
Route::post('/slack/request/leave', 'RequestLeaveController@index');

Route::group(['prefix' => 'slack', 'as' => 'slack.', 'middleware' => 'auth'], function(){
    
    Route::get('show', 'SlackControler@show');
    
    Route::get('filter', 'SlackControler@filter')->name('filter');
    
    Route::post('/filter', 'SlackControler@exportCsv')->name('filter.export');
    
});

Route::get('video', 'Courses\CourseController@index');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
