<?php 

include('include/config.class.php');
include('include/database.class.php');
include('include/controller.class.php');
include('include/view.class.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['action'])){

		$action = $_POST['action'];
		unset($_POST['action']);
		foreach($_POST as $key => $val){
			$_POST[$key] = htmlspecialchars($val, ENT_QUOTES);
		}

		if ($action == 'add_category'){

			die('yup, this is necessary');
			// $view->add_category($_POST['category_name']);

		} elseif ($action == 'add_to_budget') {

			if ($_POST['category_id'] == 'new'){
				$view->add_category($_POST['category_name']);
				$name = $_POST["category_name"];
				$new_category = $view->select('*', 'categories', "ORDER BY `id` DESC LIMIT 1");
				$_POST['category_id'] = $new_category[0]['id'];
				unset($_POST['category_name']);
			}

			$view->update_budget($_POST);

		} elseif ($action == 'update_transaction'){

			$view->update_transaction($_POST);

		} elseif ($action == 'update_amount'){

			$view->update_budget($_POST);

		}
	}
}

$referer = $config->base_url . '?' . $_SERVER['QUERY_STRING'];
header('Location:' . $referer);
