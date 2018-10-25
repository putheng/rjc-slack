<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestLeaveController extends Controller
{
    public function index(Request $request)
    {
        $payload = json_decode($request->payload);
        
        file_put_contents('count.txt', $payload->actions[0]);
    }
}
