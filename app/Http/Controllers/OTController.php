<?php

namespace App\Http\Controllers;

use App\OverTime;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOTFromResuest;

class OTController extends Controller
{
    protected $client;

    protected $url = 'https://hooks.slack.com/services/';

    protected $channel;

    protected $token;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function index()
    {
    	return view('form.ot.index');
    }

    public function store(StoreOTFromResuest $request)
    {
    	$startdate = Carbon::parse($request->startdate . ' '. $request->starttime);
    	$enddate = Carbon::parse($request->enddate . ' '. $request->endtime);

    	$totalHours = $startdate->diffInHours($enddate);

    	$value = $request->only('name', 'userid', 'department', 'reason', 'activities');
    	$data = array_merge($value, ['hours' => $totalHours]);

    	$create = OverTime::create($data);

    	$this->buildRequestOTMessage($request, $create);
    	$this->newRequestForm();

    	return back()->withSuccess('your form was successfully submitted');
    }

    public function buildRequestOTMessage(Request $request, $create)
    {
        return $this->client->post(
            $this->url .'TCDTENTL7/BDLTV9TNE/bH0otVLUIrclyu0VpCLD3rIR',
            [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => json_decode('
                    {
                        "text": "'. $this->buildRequestTo($request) .' \n*Your approval is requested to make an offer to* <@'. $request->name .'>",
                        "attachments": [
                            {
                                "text": "'. $this->defaultOffText() .' \n",
                                "fallback": "You are unable to approve",
                                "callback_id": "aprq",
                                "color": "#3AA3E3",
                                "attachment_type": "default",
                                "actions": [
                                    {
                                        "name": "approval",
                                        "text": "Approve",
                                        "type": "button",
                                        "value": "approveOt%'. $request->name .'%'. $create->id .'",
                                        "style": "primary"
                                    },
                                    {
                                        "name": "approval",
                                        "text": "Reject",
                                        "style": "danger",
                                        "type": "button",
                                        "value": "rejectOt%'. $request->name .'%'. $create->id .'",
                                        "confirm": {
                                            "title": "Are you sure?",
                                            "text": "Would you like to reject this request?",
                                            "ok_text": "Yes",
                                            "dismiss_text": "No"
                                        }
                                    }
                                ]
                            }
                        ]
                    }
                ')
            ]
        );
    }

    public function buildRequestTo(Request $request)
    {
        $id = '';
        foreach($request->request_to as $item){
            $id .= '<@'. $item .'>, ';
        }

        return rtrim($id, ',');
    }

    public function newRequestForm()
    {
        $this->client->post(
            $this->url .'TCDTENTL7/BDGR52M6F/ZYKHb8pACSY3D1bVxu4PzNKw',
            [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => json_decode('
                    {
                        "text": "Need request?",
                        "attachments": [
                            {
                                "text": "Request any approval you like by continuing below.",
                                "fallback": "Request any approval you like by continuing below.",
                                "callback_id": "wopr_game",
                                "color": "#3AA3E3",
                                "attachment_type": "default",
                                "actions": [
                                    {
                                        "name": "new",
                                        "text": "Make a request",
                                        "type": "button",
                                        "value": "newreques%DCC58KHK2%2"
                                    }
                                ]
                            }
                        ]
                    }
                ')
            ]
        );
    }

    public function defaultOffText()
    {
        return 'I would like to request your approval for my *Over time / Holiday* working\n\n *Department* '. request()->department .' \n *Reason* '. request()->reason .'\n'.'*Activities* \n\n'. $this->buildRequestText() . $this->DateIN() . $this->DateOut();
    }

    public function DateIN()
    {
        $date = request()->startdate . request()->starttime;
        $carbon = new Carbon($date);
        $time = $carbon->format('d-M-Y H:i A');

        return '\n*Start Date* :'. $time;
    }

    public function DateOut()
    {
        $date = request()->enddate . request()->endtime;
        $carbon = new Carbon($date);
        $time = $carbon->format('d-M-Y H:i A');

        return '\n\n*End Date* :'. $time;
    }

   	public function buildRequestText()
    {
        return preg_replace("/\r|\n/", "", request()->reason);
    }
}
