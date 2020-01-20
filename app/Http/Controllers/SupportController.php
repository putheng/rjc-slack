<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Support;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class SupportController extends Controller
{
	protected $client;

	public function __construct()
    {
        $this->client = new Client();
    }

    public function show(Request $request)
    {
    	return view('slack.support');
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'username' => 'required',
    		'userid' => 'required',
    		'department' => 'required',
    		'title' => 'required',
    		'description' => 'required',
    	]);

    	$support = Support::create(
    		$request->only('username', 'userid', 'title', 'description')
    	);

    	$this->buildMessage($request, $support);
    }

    public function buildMessage(Request $request, $model)
    {
        return $this->client->post(
        	'https://hooks.slack.com/services/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',
            [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => json_decode('
                    {
						"blocks": [
							{
								"type": "section",
								"text": {
									"type": "mrkdwn",
									"text": "Support is requested by <@'. $request->username .'> \n\n *Title* : '. $model->title .'\n *Description* : \n '. $model->description .'"
								}
							}
						]
					}
                ')
            ]
        );
    }}
