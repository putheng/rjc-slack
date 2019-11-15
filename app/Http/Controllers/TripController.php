<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TripController extends Controller
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
    	return view('slack.request.trip');
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'username' => 'required|min:3|max:255',
    		'userid' => 'required',
    		'department' => 'required',
    		'dateout' => 'required',
            'title' => 'required:min:3|max:255',
    		'timeout' => 'required',
    		'datein' => 'required',
            'timein' => 'required',
            'request_to' => 'required', 
    		'reason' => 'required|min:3|max:255',
    	]);

    	$create = Approval::create([
    		'username' => $request->username,
    		'userid' => $request->userid,
    		'department' => $request->department,
    		'dateout' => $request->dateout .' '. $request->timeout,
    		'datein' => $request->datein .' '. $request->timein,
    		'reason' => $request->reason,
            'title' => $request->title,
            'slackid' => $request->username,
            'body' => $this->defaultText(),
    	]);

    	$this->buildRequestMessage($request, $create);

    	return back()->withSuccess('your form was successfully submitted');
    }

    public function defaultText()
    {
        return 'I would like to request your approval for my business trip \n\n *'. request()->title .'* \n'. $this->buildRequestText() . $this->DateOut() . $this->DateIN();
    }

    public function buildRequestText()
    {
        return preg_replace("/\r|\n/", "", request()->reason);
    }

    public function DateIN()
    {
        $date = request()->datein . request()->timein;
        $carbon = new Carbon($date);
        $time = $carbon->format('d-M-Y H:i');

        return '\n*Until Time* :'. $time;
    }

    public function DateOut()
    {
        $date = request()->dateout . request()->timeout;
        $carbon = new Carbon($date);
        $time = $carbon->format('d-M-Y H:i');

        return '\n\n*Start* :'. $time;
    }

    public function buildRequestMessage(Request $request, $create)
    {
        return $this->client->post(
            $this->url .'TCDTENTL7/BKWTU1B7Z/MY5alrKR2WsixgagqI2CzK3C',
            [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => json_decode('
                    {
                        "text": "'. $this->buildRequestTo($request) .' \n*Your approval is requested to make an offer to* <@'. $request->username .'>",
                        "attachments": [
                            {
                                "text": "'. $this->defaultText() .' \n",
                                "fallback": "You are unable to approve",
                                "callback_id": "aprq",
                                "color": "#3AA3E3",
                                "attachment_type": "default",
                                "actions": [
                                    {
                                        "name": "approval",
                                        "text": "Approve",
                                        "type": "button",
                                        "value": "approveOut%'. $request->username .'%'. $create->id .'",
                                        "style": "primary"
                                    },
                                    {
                                        "name": "approval",
                                        "text": "Reject",
                                        "style": "danger",
                                        "type": "button",
                                        "value": "rejectOut%'. $request->username .'%'. $create->id .'",
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
}
