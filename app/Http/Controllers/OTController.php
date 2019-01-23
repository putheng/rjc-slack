<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OTController extends Controller
{
    public function index()
    {
    	return view('form.ot.index');
    }

    public function store(Request $request)
    {

    }
}
