<?php 

include('include/config.class.php');
include('include/database.class.php');
include('include/controller.class.php');
include('include/validation.class.php');
include('include/view.class.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	if (isset($_POST['action'])){

		$action = $_POST['action'];
		unset($_POST['action']);

		$validate->escape($_POST);

		if ($action == 'add_to_budget') {

			// move to handle logic in budget controller
			if ($_POST['category_id'] == 'new'){
				$view->add_category($_POST['category_name']);
				$name = $_POST["category_name"];
				$new_category = $view->select('*', 'budget_categories', "ORDER BY `id` DESC LIMIT 1");
				$_POST['category_id'] = $new_category[0]['id'];
				unset($_POST['category_name']);
			}

			// handle transaction classifying rules here

			$view->update_budget($_POST);

		} elseif ($action == 'update_amount'){

			$view->update_budget($_POST);

		} elseif ($action == 'update_transaction'){

			$view->update_transaction($_POST);

		}
	}
}

$referer = $config->base_url . '?' . $_SERVER['QUERY_STRING'];
header('Location:' . $referer);
