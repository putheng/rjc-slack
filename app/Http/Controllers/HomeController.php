<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $count = file_get_contents('count.txt') + 1;
        file_put_contents('count.txt', $count);
        
        return $count;
    }
}
