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
	// $this->dt = DateTime::createFromFormat('n Y', $this->month . ' ' . $this->year);