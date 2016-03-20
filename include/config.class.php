<?php

class Config {

	public $dev = true;
	public $base_url;
	public $root_dir;

	function __construct(){
		if ($_SERVER['HTTP_HOST'] == 'localhost'){
			$this->dev = true;
			date_default_timezone_set("America/Chicago");
		}
		if ($this->dev === true){

			error_reporting(E_ALL);
			ini_set("display_errors", 1);

			$this->base_url = '/simpler/';
			$this->root_dir = $_SERVER['DOCUMENT_ROOT'] . '/simpler/';
		} else {
			$this->base_url = '/';
			$this->root_dir = '/';
		}
	}

}

$config = new Config;