<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Contract;
use Illuminate\Http\Request;

class ContractUpdateController extends Controller
{
	public function __construct()
    {
        $this->client = new Client();
    }

    public function slackAuthorize()
	{
		return 'https://hooks.slack.com/services/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';
	}

	public function slackAuthorizeB()
	{
		return 'https://hooks.slack.com/services/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';
	}

    public function index()
    {
    	return view('contracts.update');
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'client_name' => 'required',
    		'vehicle_mark' => 'required',
    		'vehicle_mode' => 'required',
    		'price' => 'required',
    		'client_name_update' => 'required',
    		'vehicle_mark_update' => 'required',
    		'vehicle_mode_update' => 'required',
    		'contract_number' => 'required',
    		'price_update' => 'required'
    	]);

    	$contract = new Contract;
    	$contract->client_name = $request->client_name;
    	$contract->vehicle_mark = $request->vehicle_mark;
    	$contract->vehicle_mode = $request->vehicle_mode;
    	$contract->price = $request->price;
    	$contract->client_name_update = $request->client_name_update;
    	$contract->vehicle_mark_update = $request->vehicle_mark_update;
    	$contract->vehicle_mode_update = $request->vehicle_mode_update;
    	$contract->price_update = $request->price_update;
    	$contract->number = $request->contract_number;

    	$this->submitFormToSlack($contract);
    	$this->newRequestForm();

    	return back()->withSuccess('Form successfully submitted');
    }

	public function submitFormToSlack($contract)
    {
        $this->client->post(
            $this->slackAuthorizeB(),
            [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => json_decode('
                    {
                        "text": "*Client Name:* '. $contract->client_name .'\n *Contract No.:* '. $contract->number .' \n *Vehicle Mark:* '. $contract->vehicle_mark .'\n *Vehicle Mode: '. $contract->vehicle_mode .'*\n *Price: $'. $contract->price .'* \n\n *Update To*\n\n *Client Name:* '. $contract->client_name_update .' \n *Vehicle Mark:* '. $contract->vehicle_mark_update .'\n *Vehicle Mode: '. $contract->vehicle_mode_update .'*\n *Price: $'. $contract->price_update .'*",
                        "channel": "CGATB5S14",
                        "attachments": [
                            {
                                "fallback": "The request was approved."
                            }
                        ]
                    }
                ')
            ]
        );

    }

    public function newRequestForm()
    {
        $this->client->post(
            $this->slackAuthorize() ,
            [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => json_decode('
                    {
                        "text": "Need a form?",
                        "channel": "CG1D8VB0X",
                        "attachments": [
                            {
                                "text": "Submit any form you like by continuing below.",
                                "fallback": "Submit any form you like by continuing below.",
                                "callback_id": "wopr_game",
                                "color": "#3AA3E3",
                                "attachment_type": "default",
                                "actions": [
                                    {
                                        "url": "https://renet-slack.herokuapp.com/car/update",
                                        "text": "Request car update form",
                                        "type": "button",
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
}
