<?php

class dataHandler {

	function arrayDenester($array){
		$new_array = array();
		foreach ($array as $key => $val){
			if (is_array($val)){
				foreach ($val as $nested_key => $nested_val){
					$new_key = $key . '_' . $nested_key;
					$new_array[$new_key] = $nested_val;
				}
			} else {
				$new_array[$key] = $val;
			}
		}
		return $new_array;
	}

}

$dataHandler = new dataHandler;