<?php

class Validation {

	function escape($val){
		if (is_array($val)){
			foreach ($val as $key => $_val){
				$val[$key] = htmlspecialchars($_val, ENT_QUOTES);
			}
		} else {
			$val = htmlspecialchars($val, ENT_QUOTES);
		}
		return $val;
	}

	
}