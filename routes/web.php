<?php

Route::get('/screenshot', 'ScreenController@index');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/slack/approval/ot', 'OTController@index')->name('form.ot');
Route::post('/slack/approval/ot', 'OTController@store');

Route::post('/slack/hook', 'SlackControler@index');
Route::post('/slack/request/leave', 'ApprovalController@getResponse');

Route::get('/slack/approval/form', 'ApprovalController@index')->name('form.approval');
Route::post('/slack/approval/form', 'ApprovalController@store');

Route::get('/slack/approval/leave', 'ApprovalController@viewOff')->name('form.approval.leave');
Route::post('/slack/approval/leave', 'ApprovalController@storeOff');

Route::get('/slack/approval/form/{approval}', 'ApprovalController@view');

Route::post('/slac/approval/request', 'ApprovalController@request')->name('approval.request');

Route::group(['prefix' => 'slack', 'as' => 'slack.', 'middleware' => 'auth'], function(){
    
    Route::get('show', 'SlackControler@show')->name('show');
    
    Route::get('filter', 'SlackControler@filter')->name('filter');
    
    Route::post('/filter', 'SlackControler@exportCsv')->name('filter.export');
    
    Route::get('/report/dayOff', 'SlackControler@reportDayOff')->name('reportOff');
    Route::get('/report/dayOff/filter', 'SlackControler@reportDayFilter')->name('reportDayFilter');
    Route::put('/report/dayOff/filter', 'SlackControler@exportReport')->name('exportReport');
});

Route::get('video', 'Courses\CourseController@index');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => 'change', 'namespace' => 'Slack', 'as' => 'update.'], function(){

	Route::post('/approve/{approval}', 'ActionController@approve')->name('approve');

	Route::post('/delete/{approval}', 'ActionController@delete')->name('delete');

	Route::post('/reject/{approval}', 'ActionController@rejecte')->name('reject');

});