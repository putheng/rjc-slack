<?php

namespace App\Http\Controllers;

use App\Approver;
use App\Http\Requests\StoreDayOffFromResuest;
use App\Models\Approval;
use App\Models\ApprovalApprover;
use App\Models\Slack;
use App\OverTime;
use Carbon\Carbon;
use GuzzleHttp\Client;
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
    
    public function viewOff()
    {
        return view('slack.request.dayoff');
    }
    
    public function storeOff(StoreDayOffFromResuest $request)
    {
        $create = Approval::create([
            'username' => $request->username,
            'userid' => $request->userid,
            'title' => $request->type,
            'department' => $request->position,
            'dateout' => $request->dateout .' '. $request->timeout,
            'datein' => $request->datein .' '. $request->timein,
            'reason' => $request->reason,
            'slackid' => $request->username,
            'type' => $request->type,
            'body' => $this->defaultOffText(),
        ]);

        $this->buildRequestOffMessage($request, $create);

        return back()->withSuccess('your form was successfully submitted');
    	
    }

    public function buildRequestOffMessage(Request $request, $create)
    {
        return $this->client->post(
            $this->url .'TCDTENTL7/BKX2LMJ07/FkjcP5e5uwddmCb7GShCXWY2',
            [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => json_decode('
                    {
                        "text": "'. $this->buildRequestTo($request) .' \n*Your approval is requested to make an offer to* <@'. $request->username .'>",
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
                                        "value": "approve%'. $request->username .'%'. $create->id .'",
                                        "style": "primary"
                                    },
                                    {
                                        "name": "approval",
                                        "text": "Reject",
                                        "style": "danger",
                                        "type": "button",
                                        "value": "reject%'. $request->username .'%'. $create->id .'",
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

    public function defaultOffText()
    {
        return 'I would like to request your approval for my leave ('. request()->type .') \n\n *Branch* '. request()->branch .' \n *Section* '. request()->section .'\n'.'*Position* '. request()->position .'\n\n'. $this->buildRequestText() . $this->Dateout() . $this->DateIN();
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
    
    public function getResponse(Request $request)
    {
        file_put_contents('count.txt', $request->payload);

        $payload = json_decode($request->payload);

        $value = $payload->actions[0]->value;
        
        $explode = explode('%', $value);
        
        $response = $explode[0];
        $userid = $payload->user->id;
        $requestid = $explode[2];
        
        if($response == 'newreques')
        {
            $this->sendRequestForm($userid);
        }
        
        if($response == 'approveOut')
        {
            $approval = Approval::find($requestid);
            $approval->status = 'Approved';
            
            $approval->save();

            $approver = Approver::where('slackid', $userid)->first();

            $aa = new ApprovalApprover;
            $aa->approval_id = $requestid;
            $aa->approver_id = $approver->id;
            $aa->save();
            
            $this->sendApprovedOutRequest($userid, $approval);
            
        }
        
        if($response == 'approve')
        {
            $approval = Approval::find($requestid);
            $approval->status = 'Approved';
            
            $approval->save();

            $approver = Approver::where('slackid', $userid)->first();

            $aa = new ApprovalApprover;
            $aa->approval_id = $requestid;
            $aa->approver_id = $approver->id;
            $aa->save();
            
            $this->sendApprovedRequest($userid, $approval);
            
        }

        if($response == 'approveOt')
        {
            $approval = OverTime::find($requestid);
            
            $approval->status = 'Approved';
            
            $approval->save();
            
            $this->sendApprovedOtRequest($userid, $approval);
        }
        
        if($response == 'rejectOt')
        {
            $approval = OverTime::find($requestid);

            $approval->status = 'Rejected';
            $approval->save();
            
            $this->sendRejectOtRequest($userid, $approval);
        }
        
        if($response == 'reject')
        {
            $approval = Approval::find($requestid);
            $approval->status = 'Rejected';
            $approval->save();
            
            $this->sendRejectRequest($userid, $approval);
        }
        
        if($response == 'rejectOut')
        {
            $approval = Approval::find($requestid);
            $approval->status = 'Rejected';
            $approval->save();
            
            $this->sendRejectRequest($userid, $approval);
        }
        
        
    }

    public function sendApprovedOtRequest($id, $approve)
    {
        $this->client->post(
            $this->url .'TCDTENTL7/BKV3W22QM/7objnmxoEWQxX2RZ8ewLvaKA',
            [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => json_decode('
                    {
                        "text": "\n\nRequested *Over Time* from <@'. $approve->name .'>\n *Was approved* by <@'. $id .'>\n",
                        "channel": "GKQL2PJS1",
                        "attachments": [
                            {
                                "fallback": "The request was approved."
                            }
                        ]
                    }
                ')
            ]
        );
        
        sleep(1);
        
        $this->client->post(
            $this->url .'TCDTENTL7/BDGR52M6F/ZYKHb8pACSY3D1bVxu4PzNKw',
            [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => json_decode('
                    {
                        "text": "\n\nRequested *Over Time* from <@'. $approve->name .'>\n *Was approved* by <@'. $id .'>\n",
                        "channel": "C061EG9SL",
                        "attachments": [
                            {
                                "fallback": "The request was approved!"
                            }
                        ]
                    }
                ')
            ]
        );
    }

    public function sendRejectOtRequest($id, $approve)
    {
        $this->client->post(
            $this->url .'TCDTENTL7/BKV3W22QM/7objnmxoEWQxX2RZ8ewLvaKA',
            [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => json_decode('
                    {
                        "text": "\n\nRequested *Over Time* from <@'. $approve->name .'>\n *Was rejected* by <@'. $id .'>\n",
                        "channel": "C061EG9SL",
                        "attachments": [
                            {
                                "fallback": "The request was rejected!"
                            }
                        ]
                    }
                ')
            ]
        );
        
        sleep(1);
        
        $this->client->post(
            $this->url .'TCDTENTL7/BDGR52M6F/ZYKHb8pACSY3D1bVxu4PzNKw',
            [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => json_decode('
                    {
                        "text": "\n\nRequested *Over Time* from <@'. $approve->name .'>\n *Was rejected* by <@'. $id .'>\n",
                        "channel": "C061EG9SL",
                        "attachments": [
                            {
                                "fallback": "The request was rejected!"
                            }
                        ]
                    }
                ')
            ]
        );
    }

    public function sendApprovedOutRequest($id, $approve)
    {
        $this->client->post(
            $this->url .'TCDTENTL7/BKWTU1B7Z/MY5alrKR2WsixgagqI2CzK3C',
            [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => json_decode('
                    {
                        "text": "\n\nRequested to leave from <@'. $approve->slackid .'>\n *Was approved* by <@'. $id .'>\n",
                        "channel": "C061EG9SL",
                        "attachments": [
                            {
                                "fallback": "The request was approved."
                            }
                        ]
                    }
                ')
            ]
        );
        
        sleep(1);
        
        $this->client->post(
            $this->url .'TCDTENTL7/BDGR52M6F/ZYKHb8pACSY3D1bVxu4PzNKw',
            [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => json_decode('
                    {
                        "text": "\n\nRequested to leave from <@'. $approve->slackid .'>\n *Was approved* by <@'. $id .'>\n",
                        "channel": "C061EG9SL",
                        "attachments": [
                            {
                                "fallback": "The request was approved!"
                            }
                        ]
                    }
                ')
            ]
        );
    }
    
    public function sendApprovedRequest($id, $approve)
    {
        $this->client->post(
            $this->url .'TCDTENTL7/BKX2LMJ07/FkjcP5e5uwddmCb7GShCXWY2',
            [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => json_decode('
                    {
                        "text": "\n\nRequested to leave from <@'. $approve->slackid .'>\n *Was approved* by <@'. $id .'>\n",
                        "channel": "C061EG9SL",
                        "attachments": [
                            {
                                "fallback": "The request was approved."
                            }
                        ]
                    }
                ')
            ]
        );
        
        sleep(1);
        
        $this->client->post(
            $this->url .'TCDTENTL7/BDGR52M6F/ZYKHb8pACSY3D1bVxu4PzNKw',
            [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => json_decode('
                    {
                        "text": "\n\nRequested to leave from <@'. $approve->slackid .'>\n *Was approved* by <@'. $id .'>\n",
                        "channel": "C061EG9SL",
                        "attachments": [
                            {
                                "fallback": "The request was approved!"
                            }
                        ]
                    }
                ')
            ]
        );
    }
    
    public function sendRejectOutRequest($id, $approve)
    {
        $this->client->post(
            $this->url .'TCDTENTL7/BKWTU1B7Z/MY5alrKR2WsixgagqI2CzK3C',
            [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => json_decode('
                    {
                        "text": "\n\nRequested to leave from <@'. $approve->slackid .'>\n *Was rejected* by <@'. $id .'>\n",
                        "channel": "C061EG9SL",
                        "attachments": [
                            {
                                "fallback": "The request was rejected!"
                            }
                        ]
                    }
                ')
            ]
        );
        
        sleep(1);
        
        $this->client->post(
            $this->url .'TCDTENTL7/BDGR52M6F/ZYKHb8pACSY3D1bVxu4PzNKw',
            [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => json_decode('
                    {
                        "text": "\n\nRequested to leave from <@'. $approve->slackid .'>\n *Was rejected* by <@'. $id .'>\n",
                        "channel": "C061EG9SL",
                        "attachments": [
                            {
                                "fallback": "The request was rejected!"
                            }
                        ]
                    }
                ')
            ]
        );
    }

    public function sendRejectRequest($id, $approve)
    {
        $this->client->post(
            $this->url .'TCDTENTL7/BDLTV9TNE/bH0otVLUIrclyu0VpCLD3rIR',
            [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => json_decode('
                    {
                        "text": "\n\nRequested to leave from <@'. $approve->slackid .'>\n *Was rejected* by <@'. $id .'>\n",
                        "channel": "C061EG9SL",
                        "attachments": [
                            {
                                "fallback": "The request was rejected!"
                            }
                        ]
                    }
                ')
            ]
        );
        
        sleep(1);
        
        $this->client->post(
            $this->url .'TCDTENTL7/BDGR52M6F/ZYKHb8pACSY3D1bVxu4PzNKw',
            [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => json_decode('
                    {
                        "text": "\n\nRequested to leave from <@'. $approve->slackid .'>\n *Was rejected* by <@'. $id .'>\n",
                        "channel": "C061EG9SL",
                        "attachments": [
                            {
                                "fallback": "The request was rejected!"
                            }
                        ]
                    }
                ')
            ]
        );
    }

    public function index(Request $request)
    {
    	return view('slack.request.form');
    }
    
    public function view(Request $request, Approval $approval)
    {
        return view('slack.request.view', compact('approval'));
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

    public function getNewRequestForm()
    {
        return $this->client->post(
            $this->url .'TCDTENTL7/BDGR52M6F/ZYKHb8pACSY3D1bVxu4PzNKw',
            [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => json_decode('
                    {
                        "text": "Request any approval you like by continuing below.",
                        "channel": "C061EG9SL",
                        "attachments": [
                            {
                                "fallback": "Your request form at https://flights.example.com/book/r123456",
                                "actions": [
                                    {
                                        "type": "button",
                                        "text": "Request Working Outside",
                                        "url": "http://renet-slack.herokuapp.com/slack/approval/form",
                                        "style": "primary"
                                    },
                                    {
                                        "type": "button",
                                        "text": "Request Day Off",
                                        "url": "http://renet-slack.herokuapp.com/slack/approval/leave",
                                        "style": "primary"
                                    },
                                    {
                                        "type": "button",
                                        "text": "Request Over Time",
                                        "url": "http://renet-slack.herokuapp.com/slack/approval/ot",
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
                                        "text": "Request Working Outside",
                                        "url": "http://renet-slack.herokuapp.com/slack/approval/form?id='. $id .'",
                                        "style": "primary"
                                    },
                                    {
                                        "type": "button",
                                        "text": "Request Day Off",
                                        "url": "http://renet-slack.herokuapp.com/slack/approval/leave?id='. $id .'",
                                        "style": "primary"
                                    },
                                    {
                                        "type": "button",
                                        "text": "Request Over Time",
                                        "url": "http://renet-slack.herokuapp.com/slack/approval/ot?id='. $id .'",
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

        $this->newRequestForm();
        

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
            $id .= '<@'. $item .'>, ';
        }

        return rtrim($id, ',');
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

    public function defaultText()
    {
        return 'I would like to request your approval for my leave \n\n *'. request()->title .'* \n'. $this->buildRequestText() . $this->Dateout() . $this->DateIN();
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
}
