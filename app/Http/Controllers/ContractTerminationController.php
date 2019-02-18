<?php

namespace App\Http\Controllers;

use App\Termination;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ContractTerminationController extends Controller
{
    public function __construct()
    {
        $this->client = new Client();
    }

	public function index()
	{
		return view('contracts.termination');
	}

	public function store(Request $request)
	{
		$this->validate($request, [
			'contract' => 'required',
			'name' => 'required',
			'payoff' => 'required',
			'sale' => 'required',
			'appointment' => 'required',
			'date' => 'required'
		]);

		$create = Termination::create(
			$request->only('contract', 'name', 'payoff', 'sale', 'date', 'appointment')
		);

		$this->submitFormToSlack($create);
		$this->newRequestForm();

		return back()->withSuccess('Form successfuly submited');
	}

	public function slackAuthorize()
	{
		return 'https://hooks.slack.com/services/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';
	}

	public function submitFormToSlack($create)
    {
        $this->client->post(
            $this->slackAuthorize(),
            [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => json_decode('
                    {
                        "text": "\n\n\n\n *Contract Number:* '. $create->contract .'\n *Client Name:* '. $create->name .'\n *Type:* '. $create->payoff .' \n *Sales Staff:* '. $create->sale .'\n *Termination Date:* '. $create->date .'\n *Appointment Date:* '. $create->appointment .'",
                        "channel": "CG1D8VB0X",
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
                        "attachments": [
                            {
                                "text": "Submit any terminate form you like by continuing below.",
                                "fallback": "Submit any terminate form you like by continuing below.",
                                "callback_id": "wopr_game",
                                "color": "#3AA3E3",
                                "attachment_type": "default",
                                "actions": [
                                    {
                                        "url": "https://renet-slack.herokuapp.com/contract_termination",
                                        "text": "Request contract terminate form",
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

    public function webhoos(Request $request)
    {

    }
}
