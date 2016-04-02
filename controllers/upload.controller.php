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
		$action_page = $config->base_url . 'upload';
		require_once($config->root_dir . 'views/view.class.php');
		require_once($config->root_dir . 'views/upload.template.php');
	}
	

