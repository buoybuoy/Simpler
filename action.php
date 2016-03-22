<?php 

include('include/config.class.php');
include('include/database.class.php');
include('include/controller.class.php');
include('include/view.class.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['category_name'])){
		$view->add_category($_POST['category_name']);
	}
    // var_dump($_POST); die();
}

header('Location:' . $config->base_url);
