<?php
use Carbon\Carbon;

if(!function_exists('date_cal')){
	function date_cal($from, $to){
		$date = Carbon::parse($from);
		$to = Carbon::parse($to);

		return $date->diffInHours($to);
	}
}