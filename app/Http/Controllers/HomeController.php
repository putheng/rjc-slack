<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $value = $request->getContent();
        
        file_put_contents('hook.txt', $value);
        
        $count = file_get_contents('count.txt') + 1;
        file_put_contents('count.txt', $count);
        
        return $count;
    }
}
