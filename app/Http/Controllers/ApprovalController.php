<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Approval;
use Illuminate\Http\Request;

class ApprovalController extends Controller
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
    	return view('slack.request.form');
    }
    
    public function request(Request $request)
    {
        $text = $request->text;
        $id = $request->user_id;
        
        $check = ['Approval request', 'approval request', 'Approval Request'];
        
        if(in_array($text, $check)){
            $this->sendRequestForm($id);
        }
    }
    
    public function sendRequestForm($id)
    {
        return $this->client->post(
            $this->url .'TCDTENTL7/BDGR52M6F/ZYKHb8pACSY3D1bVxu4PzNKw',
            [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => json_decode('
                    {
                        "text": "<@'. $id .'> Request any approval you like by continuing below.",
                        "channel": "C061EG9SL",
                        "attachments": [
                            {
                                "fallback": "Your request form at https://flights.example.com/book/r123456",
                                "actions": [
                                    {
                                        "type": "button",
                                        "text": "Submit Your Form",
                                        "url": "http://renet-slack.herokuapp.com/slack/approval/form?id="'. $id .'&token='. str_random(120) .',
                                        "style": "primary"
                                    }
                                ]
                            }
                        ]
                    }
                ')
            ]
        );
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

    	Approval::create([
    		'username' => $request->username,
    		'userid' => $request->userid,
    		'department' => $request->department,
    		'dateout' => $request->dateout .' '. $request->timeout,
    		'datein' => $request->datein .' '. $request->timein,
    		'reason' => $request->reason,
            'title' => $request->title
    	]);

        $this->buildRequestMessage($request);

        return back()->withSuccess('your form was successfully submitted');
    }

    public function buildApprovedMessage()
    {
        return $this->client->post(
            $this->url .'TCDTENTL7/BDGR52M6F/ZYKHb8pACSY3D1bVxu4PzNKw',
            [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => json_decode('
                    {
                        "text": "<@UCC9S0V4Z> \nYour approval request is approved by <@UCCBRCTCZ>",
                        "attachments": [
                            {
                                "text": "Please click \'Thank You\' button",
                                "fallback": "You are unable to request",
                                "callback_id": "aprq",
                                "color": "#3AA3E3",
                                "attachment_type": "default",
                                "actions": [
                                    {
                                        "name": "approval",
                                        "text": "Thank You",
                                        "type": "button",
                                        "value": "thankyou",
                                        "style": "primary"
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
            $id .= '<@'. $item .'>';
        }

        return $id;
    }

    public function buildRequestText()
    {
        return preg_replace("/\r|\n/", "", request()->reason);
    }

    public function DateIN()
    {
        $date = request()->datein . request()->timein;
        $carbon = new Carbon($date);
        $time = $carbon->format('d-M-Y H:i A');

        return '\n*In* :'. $time;
    }

    public function DateOut()
    {
        $date = request()->dateout . request()->timeout;
        $carbon = new Carbon($date);
        $time = $carbon->format('d-M-Y H:i A');

        return '\n\n*Out* :'. $time;
    }

    public function defaultText()
    {
        return 'I would like to request your approval for my leave';
    }

    public function buildRequestMessage(Request $request)
    {
        return $this->client->post(
            $this->url .'TCDTENTL7/BDGR52M6F/ZYKHb8pACSY3D1bVxu4PzNKw',
            [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => json_decode('
                    {
                        "text": "'. $this->buildRequestTo($request) .' \n*Your approval is requested to make an offer to* <@UCC9S0V4Z>",
                        "attachments": [
                            {
                                "text": "'. $this->defaultText() .'\n\n *'. $request->title .'* \n'. $this->buildRequestText() . $this->Dateout() . $this->DateIN() .' \n\n<http://www.foo.com|Read Doc>",
                                "fallback": "You are unable to approve",
                                "callback_id": "aprq",
                                "color": "#3AA3E3",
                                "attachment_type": "default",
                                "actions": [
                                    {
                                        "name": "approval",
                                        "text": "Approval",
                                        "type": "button",
                                        "value": "approve",
                                        "style": "primary"
                                    },
                                    {
                                        "name": "approval",
                                        "text": "Reject",
                                        "style": "danger",
                                        "type": "button",
                                        "value": "reject",
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
}