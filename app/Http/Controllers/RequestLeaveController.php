<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestLeaveController extends Controller
{
    public function index(Request $request)
    {
        file_put_contents('count.txt', urldecode($request->getContent()));
    }
}

//sotheary9niko@gmail.com