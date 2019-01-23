<?php
use Carbon\Carbon;

if(!function_exists('date_cal')){
	function date_cal($from, $to){
		$date = Carbon::parse($from);
		$to = Carbon::parse($to);

		$hours = $date->diffInHours($to);

		if($hours <= 9){
			return 8;
		}
	}
}