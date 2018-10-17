<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
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
        
        $morning = ['Good morning', 'Good Morning', 'good morning', 'good Morning', 'morning', 'Morning'];
        $bye = ['Good Bye', 'Good Bye', 'Good bye', 'good bye', 'good by', 'Bye', 'bye', 'by', 'By'];
        
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
        $date = new Carbon;
        
        $slacks = Work::whereDate('created_at', '>=', $date->now()->startOfMonth()->format('Y-m-d'))
                    ->whereDate('created_at', '<=', $date->now()->endOfMonth()->format('Y-m-d'))
                    ->paginate(50);
        
        return view('slack.show', compact('slacks', 'date'));
    }
    
    public function filter(Request $request)
    {
        $slacks = Work::filter($request)->paginate(50);
        
        return view('slack.filter', compact('slacks'));
    }
    
    public function exportCsv(Request $request)
    {
        $filename = 'exports-'. date('Y-m-d-h-A') .'.csv';
        
        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename='. $filename,
            'Expires'             => '0',
            'Pragma'              => 'public',
        ];
        
        $list = Work::select(DB::raw('username as name, created_at as in, updated_at as out'))
                ->filter($request)
                ->get()
                ->toArray();
    
        array_unshift($list, array_keys($list[0]));
    
        $callback = function() use ($list) 
        {
            $FH = fopen('php://output', 'w');
            foreach ($list as $row) { 
                fputcsv($FH, $row);
            }
            fclose($FH);
        };
    
        return response()->stream($callback, 200, $headers);
    }
}
