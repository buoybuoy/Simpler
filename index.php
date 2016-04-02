<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once('include/config.class.php');

$request_url = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
$script_url  = (isset($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : '';
	
// defaults
$load_controller = 'budget';
$year = date("Y");
$month = date("m");

// parse URL to replace defaults with requested
if($request_url != $script_url) $url = trim(preg_replace('/'. str_replace('/', '\/', str_replace('index.php', '', $script_url)) .'/', '', $request_url, 1), '/');
$segments = explode('/', $url);
if(isset($segments[0]) && $segments[0] != '') $load_controller = $segments[0];
if(isset($segments[1]) && $segments[1] != '') $year = $segments[1];
if(isset($segments[2]) && $segments[2] != '') $month = $segments[2];

// if(isset($_GET['p'])){
// 	$load_controller = $_GET['p'];
// }

$requested = $config->root_dir . 'controllers/' . $load_controller . '.controller.php';
if(file_exists($requested)){
	include($requested);
} else {
	header('Location:' . $config->base_url);
}








?>





