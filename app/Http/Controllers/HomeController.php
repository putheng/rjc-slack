<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'slackid' => 'required',
            'username' => 'required',
            'text' => 'required',
        ]);
        
        $work = new Work;
        
        $work->slackid      = $request->user_id;
        $work->username    = $request->user_name;
        $work->text         = $request->text;
        
        $work->save();
        
        return response(null, 200);
    }
}
