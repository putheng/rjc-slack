<?php

use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/slack/hook', 'HomeController@index');

Route::get('test', function(Request $request){
    return $request->ip();
});