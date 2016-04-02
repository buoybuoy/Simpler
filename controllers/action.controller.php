<?php

	require_once($config->root_dir . 'include/database.class.php');
	require_once($config->root_dir . 'models/budget.model.php');
	$budgetModel = new budget($database);

	require_once($config->root_dir . 'controllers/controller.class.php');
	$controller = new controller;

	require_once($config->root_dir . 'helpers/validation.class.php');
	$validate = new Validation;

	require_once($config->root_dir . 'helpers/cache.class.php');
	$cache = new cache;

	$controller->set_month_and_year($_GET);
	$month = $controller->month;
	$year = $controller->year;

	$ajax = false;

	if (isset($_POST)){

		if (isset($post['ajax'])){
			$ajax = $post['ajax'];
			unset($post['ajax']);
		}

		$post = $validate->escape($_POST);
		if (isset($post['action'])){
			$action = $post['action'];
			unset($post['action']);

			if ($action == 'update_budget'){
				$budgetModel->update_budget($month, $year, $post);
			}

			elseif ($action == 'update_transaction'){
				$budgetModel->update_transaction($month, $year, $post);
			}

			elseif ($action == 'delete_category'){
				$budgetModel->delete_category($post['budget_category_id']);
			}
			$budgetModel->clean_database();
		}

	}

	if ($ajax == true){

		// violating DRY with this initialization shit

		$budgetModel->initialize_month_budget($month, $year);
		$budgeted_amounts = $budgetModel->month_budget;
		$all_categories = $budgetModel->all_categories;	
		$unused_categories = $budgetModel->unused_categories;
		$balance = $budgetModel->account_balance;
		$action_page = $config->base_url . 'test/?p=action&m=' . $month . '&y=' . $year;
		require_once($config->root_dir . 'views/view.class.php');
		require_once($config->root_dir . 'views/ajax.template.php');
	} else {
		// fix this with logic to get referer and handle cache
		header('Location:' . $config->base_url . 'test');
	}