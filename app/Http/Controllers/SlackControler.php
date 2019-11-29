<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Work;
use App\OverTime;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class SlackControler extends Controller
{
    public function index(Request $request)
    {
        // take data from Slack and save to a file
        file_put_contents('count.txt', $request->all());
        
        // get text from Slack by user they enter
        $text = $request->text;

        //get Slack's User ID
        $id = $request->user_id;
        
        // lists of word, is match these word we will add to DB
        $morning = ['Good morning', 'Good Morning', 'good morning', 'good Morning', 'morning', 'Morning'];
        $bye = ['Good Bye', 'Good Bye', 'Good bye', 'good bye', 'good by', 'Bye', 'bye', 'by', 'By', 'Goodbye', 'GoodBye'];
        
        $work = new Work;
        
        $check = $work->isInToday($id);
        
        if($check->count())
        {
            // check if trigger work from Slack is match list words above
            // if match Good bye mean they leav office, so we will set as timeout
            if(in_array($text, $bye))
            {
                $check->update([
                    'out' => $text,
                ]);
            }
        }else
        
        // check if trigger work from Slack is match list words above
        // if match Good morning list, mean they start working, so we will set as in
        if(in_array($text, $morning))
        {
            // add record to DB
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

        $startWeek = $date->modify('this week')->format('Y-m-d');
        $endWeek = $date->modify('this week +6 days')->format('Y-m-d');
        
        $slacks = Work::whereDate('created_at', '>=', $startWeek)
                    ->whereDate('created_at', '<=', $endWeek)
                    ->orderby('works.id', 'desc')
                    ->paginate(50);
        
        return view('slack.show', compact('slacks', 'date'));
    }
    
    public function reportDayOff(Request $request)
    {
        $date = new Carbon;
        
        $approvals = Approval::whereDate('dateout', '>=', $date->modify('this week')->format('Y-m-d'))
                    ->whereDate('dateout', '<=', $date->modify('this week +6 days')->format('Y-m-d'))
                    ->whereNotNull('type')
                    ->where('status', 'Approved')
                    ->orderby('approvals.id', 'desc')
                    ->paginate(50);

        return view('slack.report.index', compact('approvals', 'date'));
    }

    // Export day off report
    function exportReport(Request $request)
    {
        $filename = 'report-off-'. date('Y-m-d-h-i-s-A') .'.csv';
        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename='. $filename,
            'Expires'             => '0',
            'Pragma'              => 'public',
        ];

        $list = Approval::select('name', 'type', 'dateout', 'datein', 'reason', 'status')
                ->join('slacks', 'slacks.slackid', '=', 'approvals.slackid')
                ->whereNotNull('type')
                ->filter($request)
                ->where('status', 'Approved')
                ->orderby('approvals.id', 'desc')
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

    public function reportDayFilter(Request $request)
    {
        $approvals = Approval::filter($request)
                ->whereNotNull('type')
                ->orderby('id', 'desc')
                ->paginate(50);

        return view('slack.report.filter', compact('approvals'));
    }
    
    public function filter(Request $request)
    {
        $slacks = Work::filter($request)->orderBy('id', 'desc')->paginate(50);
        
        return view('slack.filter', compact('slacks'));
    }
    
    public function exportCsv(Request $request)
    {
        $filename = 'report-checkin-'. date('Y-m-d-h-i-s-A') .'.csv';
        
        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename='. $filename,
            'Expires'             => '0',
            'Pragma'              => 'public',
        ];
        
        $list = Work::select(DB::raw('username as name, created_at as in, updated_at as out, status'))
                ->filter($request)
                ->where('status', 'Approved')
                ->orderby('id', 'desc')
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
