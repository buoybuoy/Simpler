<?php 

include('include/config.class.php');
include('include/database.class.php');
include('include/controller.class.php');
include('include/validation.class.php');
include('include/view.class.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// var_dump($_POST); exit;

	if (isset($_POST['action'])){

		$action = $_POST['action'];
		unset($_POST['action']);

		$validate->escape($_POST);

		if ($action == 'update_budget'){

			$view->update_budget($_POST);

		} elseif ($action == 'update_transaction'){

			$view->update_transaction($_POST);

		}
	}
}

$referer = $config->base_url . '?' . $_SERVER['QUERY_STRING'];
header('Location:' . $referer);
