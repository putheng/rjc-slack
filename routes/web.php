<?php

use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/slack/hook', function(Request $request){
    
    return response($request->challenge, 200);
    
});