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
            'text' => 'required',
        ]);
        
        $text = $request->text;
        
        $work = new Work;
        
        $check = $work->isInToday($request->user_id);
        
        if(!$check->count() && $text !== 'good bye'){
        
            $work->slackid  = $request->user_id;
            $work->username = $request->user_name;
            $work->in       = $text;
            
            $work->save();
            
        }
        
        if($text === 'good bye'){
            $check->update([
                'out' => $text,
            ]);
        }
        
        return response(null, 200);
    }
}
