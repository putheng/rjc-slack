<?php

use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'slack', 'as' => 'slack.', 'middleware' => 'auth'], function(){
    
    Route::post('hook', 'SlackControler@index');
    Route::get('show', 'SlackControler@show');
    
    Route::get('filter', 'SlackControler@filter')->name('filter');
    
});

Route::get('video', 'Courses\CourseController@index');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
