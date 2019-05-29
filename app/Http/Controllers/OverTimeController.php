<?php

namespace App\Http\Controllers;

use App\OverTime;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OverTimeController extends Controller
{
    public function index()
    {
    	$date = new Carbon;

        $today = $date->modify('first day of this month')->format('Y-m-d');
        $end = $date->modify('last day of this month')->format('Y-m-d');
        
        $slacks = OverTime::whereDate('created_at', '>=', $today)
        	->whereDate('created_at', '<=', $end)
        	->orderby('id', 'desc')
                    ->paginate(50);
        
        return view('slack.overtime', compact('slacks', 'date'));
    }

    public function filter(Request $request)
    {
    	$date = new Carbon;

        $today = $date->parse($request->from)->format('Y-m-d');
        $end = $date->modify($request->to)->format('Y-m-d');
        
        $slacks = OverTime::whereDate('created_at', '>=', $today)
        	->whereDate('created_at', '<=', $end)
        	->orderby('id', 'desc')
                    ->paginate(50);
        
        return view('slack.overtime', compact('slacks', 'date'));
    }
}
