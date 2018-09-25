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
        $id = $request->user_id;
        
        $work = new Work;
        
        $check = $work->isInToday($id);
        
        if($check->count()){
        
            if($text == 'good bye'){
                $check->update([
                    'out' => $text,
                ]);
                
                return;
            }
        }
        
        $work->slackid  = $id;
        $work->username = $request->user_name;
        $work->in       = $text;
        
        $work->save();
        
        
        return response(null, 200);
    }
}
