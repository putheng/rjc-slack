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
			// 'chhoeng.sreyleak@renet.com.kh',
			// 'shizuka.aoki@renet.com.kh',
			// // 'heang.mouyteang@renet.com.kh',*
			// 'hirose.daichi@renet.jp',
			// 'masahiro.sunaga@renet.com.kh',
			// 'niioka.naoki@renet.jp',
			// 'kumai.yuichi@renet.jp',
			// 'yamane.hideyuki@renet.jp',
			// 'kuch.kimlek@renet.com.kh',
			// 'masamichi.nasuno@renet.com.kh',
			// 'kuroda@renet.jp',
			// 'murai.katsushi@renet.jp',
			// // 'yamada.masumi@renet.jp',*
			// 'masuda.takayuki@renet.jp',
			// 'yamaguchi.kaori@renet.jp',
			// 'pha.nary@renet.com.kh',
			// 'preap.oudom@renet.com.kh',
			// 'leav.dara@renet.com.kh',
			// 'miyaji.naoki@renet.jp'
		];

		$data = [
			'current' => $current,
			'total' => $total,
			'sa1' => $request->sa1,
			'sa2' => $request->sa2,
			'sa3' => $request->sa3,
			'mhr' => $mhr,
		];
		    
		Mail::send('emails.cash', $data, function($message) use ($to_name, $to_email) {
		    $message->to($to_email, $to_name)
		            ->subject('Renet Daily Cash Situation');
		    $message->from('info@renet.com.kh', 'Renet information');
		});

		return 'ok';
    }
}
