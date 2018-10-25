<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use Illuminate\Http\Request;

class RequestLeaveController extends Controller
{
    public function index(Request $request)
    {
        $payload = json_decode($request->payload);
        
        $value = $payload->actions[0]->value;
        
        file_put_contents('count.txt', $value);
        
        $explode = explode('%', $value);
        
        $response = $explode[0];
        $userid = $explode[1];
        $requestid = $explode[2];
        
        if($response == 'approve'){
            $approval = Approval::find($requestid);
            
            $approval->status = true;
            
            $approval->save();
        }
        
        
    }
}
