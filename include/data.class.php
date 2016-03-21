<?php

class data {

	function dollar($amount){
		$adjusted = round($amount/10000, 2);
		return $adjusted;
	}

	function time($time){
		$new_time = $time/1000;
		$return_time = date("Y-m-d H:i:s", $new_time);
		return $return_time;
	}

}

$data = new data;