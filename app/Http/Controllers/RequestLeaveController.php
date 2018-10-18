<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestLeaveController extends Controller
{
    public function index(Request $request)
    {
        
        file_put_contents('count.txt', json_encode($request->all()));
    }
}
