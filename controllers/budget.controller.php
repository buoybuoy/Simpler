<?php

	require_once($config->root_dir . 'include/database.class.php');
	require_once($config->root_dir . 'models/budget.model.php');
	$model = new model($database);

	$year = date("Y");
	$month = date("m");
	if (isset($_GET['y'])){
		$year = $_GET['y'];
	}
	if (isset($_GET['m'])){
		$month = $_GET['m'];
	}

	$budgeted_amounts = $model->categorize_transactions(
		$model->get_budgeted_amounts($month, $year),
		$model->get_month_transactions($month, $year)
	);

	$all_categories = $model->get_all_categories();
	$unused_categories = $all_categories;
	foreach ($budgeted_amounts as $key => $budgeted_amount){
		unset($unused_categories[$key]);
	}
	
	$balance = $model->get_account_balance($month, $year);

	$title = 'test';

	$action_page = $config->base_url . 'action.php';

	require_once($config->root_dir . 'views/view.class.php');
	require_once($config->root_dir . 'views/budget.template.php');