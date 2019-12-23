<?php


Route::get('/fetch/data', 'ApiController@index');
Route::get('/webhook', 'WebHookController@index');

Route::get('/webhoos/contract_termination', 'ContractTerminationController@webhoos');

Route::get('/contract_termination', 'ContractTerminationController@index')->name('contract.terminate');
Route::post('/contract_termination', 'ContractTerminationController@store');

Route::get('/', 'SlackControler@show');

Route::get('/slack/approval/trip', 'TripController@index')->name('form.trip');
Route::post('/slack/approval/trip', 'TripController@store');

Route::get('/slack/approval/ot', 'OTController@index')->name('form.ot');
Route::post('/slack/approval/ot', 'OTController@store');

Route::post('/slack/hook', 'SlackControler@index');
Route::post('/slack/request/leave', 'ApprovalController@getResponse');

Route::get('/slack/request/leave/new', 'ApprovalController@getNewRequestForm');

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
    
    Route::get('/report/off', 'SlackControler@reportDayOff')->name('reportOff');
    Route::get('/report/ot', 'OverTimeController@index')->name('ot');
    Route::get('/report/ot/filter', 'OverTimeController@filter')->name('off.filter');

    Route::get('/report/off/filter', 'SlackControler@reportDayFilter')->name('reportDayFilter');
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

Route::get('/car/update', 'ContractUpdateController@index')->name('contract.update');
Route::post('/car/update', 'ContractUpdateController@store');