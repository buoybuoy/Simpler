<?php

$dump = false;
$redirect = true;

include('include/validation.class.php');
include('include/action.class.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// debug
	if ($dump == true){ var_dump($_POST); exit; }

	$_POST = $validate->escape($_POST);

	$action = new action($_POST, $_GET);

}

// debug
if ($redirect == true){
	$referer = $config->base_url . '?' . $_SERVER['QUERY_STRING'];
	header('Location:' . $referer);
}
