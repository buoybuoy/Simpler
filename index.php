<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

// include('include/view.class.php');

// $view->load_template();

require_once('include/config.class.php');

$load_controller = 'budget';

if(isset($_GET['p'])){
	$load_controller = $_GET['p'];
}

$requested = $config->root_dir . 'controllers/' . $load_controller . '.controller.php';

if(file_exists($requested)){
	include($requested);
} else {
	header('Location:' . $config->base_url);
}








?>





