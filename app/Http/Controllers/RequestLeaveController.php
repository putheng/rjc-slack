<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestLeaveController extends Controller
{
    public function index(Request $request)
    {
        return $request->all();
        
        //file_put_contents('count.txt', $request->all()->toJson());
    }
}
