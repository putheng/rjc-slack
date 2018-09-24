<?php

use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/slack/hook', 'HomeController@index');

Route::get('user', function(){
    $users = App\User::all();
    
    dd($users);
});

Route::get('video', 'Courses\CourseController@index');