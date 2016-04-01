<?php

class cache{

	function filter($get){
		if (isset($get['c'])){
			unset($get['c']);
		}
		return $get;
	}

	function generate(){
		return rand();
	}
}