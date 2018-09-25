<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'user_name' => 'required',
            'in' => 'required',
        ]);
        
        $work = new Work;
        
        $check = $work->isInToday($request->user_id);
        dd($check->get());
        if(!$check->count()){
        
            $work->slackid  = $request->user_id;
            $work->username = $request->user_name;
            $work->in       = $request->text;
            
            $work->save();
            
            return;
            
        }
        
        $check->update([
            'out' => $request->text,
        ]);
        
        return response(null, 200);
    }
}
