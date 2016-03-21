<?php

include('config.class.php');
include('data.class.php');
include('database.class.php');


if (!empty($_GET)){
	if (isset($_GET['y'])){
		$year = $_GET['y'];
	} else {
		$year = date("Y");
	}
	if (isset($_GET['m'])){
		$month = $_GET['m'];
		$stipulation = "MONTH(date) = $month AND YEAR(date) = $year";

		$dt = DateTime::createFromFormat('!m', $month);
		$title = $dt->format('F') . ' ' . $year;
		
	} else {
		$stipulation = "YEAR(date) = $year";
		$title = $year;
		
	}

	$transactions = $database->get_transactions($stipulation);

} else {

	$transactions = $database->get_transactions(null);
	$title = 'All Transactions';

}


?>