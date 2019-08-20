<?php

namespace App\Http\Controllers;

use App\Http\Resources\SlackResource;
use App\Models\Slack;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index(Request $request)
    {
    	return new SlackResource(
    		Slack::where('slackid', $request->id)->first()
    	);
    }
}
