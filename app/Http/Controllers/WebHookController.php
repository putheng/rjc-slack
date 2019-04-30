<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WebHookController extends Controller
{
    public function index()
    {
		$to_name = 'Putheng';
		$to_email = ['putheng@renet.com.kh', 'puthengemail@gmail.com'];

		$data = [
			'name'=>"Sam Jose",
			"body" => "Test mail"
		];
		    
		Mail::send('emails.cash', $data, function($message) use ($to_name, $to_email) {
		    $message->to($to_email, $to_name)
		            ->subject('Renet Daily Cash');
		    $message->from('info@renet.com.kh', 'Renet information');
		});
    }
}
