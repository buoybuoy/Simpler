<?php


class Config {

	public $dev = true;
	public $base_url;
	public $root_dir;

	function __construct(){
		$this->dev = true;
		date_default_timezone_set("America/Chicago");
		error_reporting(E_ALL);
		ini_set("display_errors", 1);
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		$this->base_url = '/simpler/';
		$this->root_dir = $_SERVER['DOCUMENT_ROOT'] . '/simpler/';
	}

}

$config = new Config;