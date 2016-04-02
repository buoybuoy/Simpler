<?php

	require_once($config->root_dir . 'include/database.class.php');
	require_once($config->root_dir . 'models/budget.model.php');
	$budgetModel = new budget($database);

	require_once($config->root_dir . 'controllers/controller.class.php');
	$controller = new controller();

	$controller->set_month_and_year($_GET);

	$month = $controller->month;
	$year = $controller->year;

	$budgetModel->initialize_month_budget($month, $year);

	// globalizing initialize_month_budget created variables
	$budgeted_amounts = $budgetModel->month_budget;
	$all_categories = $budgetModel->all_categories;	
	$unused_categories = $budgetModel->unused_categories;
	$balance = $budgetModel->account_balance;

	// temporary until v2 launch
	$title = 'test';
	$action_page = $config->base_url . '?p=action&m=' . $month . '&y=' . $year;

	require_once($config->root_dir . 'views/view.class.php');
	require_once($config->root_dir . 'views/budget.template.php');