<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;

class SlackControler extends Controller
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
        
        $morning = ['Good morning', 'Good Morning', 'good morning', 'good Morning'];
        $bye = ['Good Bye', 'Good Bye', 'Good bye', 'good bye', 'good by'];
        
        $work = new Work;
        
        $check = $work->isInToday($id);
        
        if($check->count())
        {
            if(in_array($text, $bye))
            {
                $check->update([
                    'out' => $text,
                ]);
            }
        }else
        
        if(in_array($text, $morning))
        {
            $work->slackid  = $id;
            $work->username = $request->user_name;
            $work->in       = $text;
            
            $work->save();
        }
        
        return response(null, 200);
    }
    
    public function show(Request $request)
    {
        $slacks = Work::paginate(50);
        
        return view('slack.show', compact('slacks'));
    }
    
    public function filter(Request $request)
    {
        $slacks = Work::filter($request)->paginate(50);
        
        return view('slack.filter', compact('slacks'));
    }
}
