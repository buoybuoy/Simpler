<?php

	require_once($config->root_dir . 'include/database.class.php');
	require_once($config->root_dir . 'models/budget.model.php');
	require_once($config->root_dir . 'models/upload.model.php');
	$uploadModel = new upload($database);

	require_once($config->root_dir . 'controllers/controller.class.php');
	$controller = new controller();

	if (!empty($_FILES)) {
		$uploadModel->upload_file($_FILES);
		header('Location:' . $config->base_url);
	} else {
		$action_page = $config->base_url . 'test/?p=upload';
		require_once($config->root_dir . 'views/view.class.php');
		require_once($config->root_dir . 'views/upload.template.php');
	}

	// $controller->set_month_and_year($_GET);

	// $month = $controller->month;
	// $year = $controller->year;

	// $budgetModel->initialize_month_budget($month, $year);

	// // globalizing initialize_month_budget created variables
	// $budgeted_amounts = $budgetModel->month_budget;
	// $all_categories = $budgetModel->all_categories;	
	// $unused_categories = $budgetModel->unused_categories;
	// $balance = $budgetModel->account_balance;

	// // temporary until v2 launch
	// $title = 'test';
	

