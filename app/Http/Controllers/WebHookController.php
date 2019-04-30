<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WebHookController extends Controller
{
    public function index(Request $request)
    {
		$current = $request->current;
		$total = $request->total;
		$mhr = $request->mhr;

		$to_name = 'Putheng';
		$to_email = [
			'putheng@renet.com.kh',
			'chhoeng.sreyleak@renet.com.kh',
			'shizuka.aoki@renet.com.kh',
			'heang.mouyteang@renet.com.kh',
			'hirose.daichi@renet.jp',
			'masahiro.sunaga@renet.com.kh',
			'niioka.naoki@renet.jp',
			'kumai.yuichi@renet.jp',
			'yamane.hideyuki@renet.jp',
			'kuch.kimlek@renet.com.kh',
			'masamichi.nasuno@renet.com.kh',
		];

		$data = [
			'current' => $current,
			'total' => $total,
			'mhr' => $mhr,
		];
		    
		Mail::send('emails.cash', $data, function($message) use ($to_name, $to_email) {
		    $message->to($to_email, $to_name)
		            ->subject('Renet Daily Cash');
		    $message->from('info@renet.com.kh', 'Renet information');
		});
    }
}