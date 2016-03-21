<?php

include('../include/config.class.php');
include('../include/data.class.php');
include('../include/database.class.php');

$filename = 'test_3-20-16.json';
$file = $config->root_dir . 'upload/data/' . $filename;
$string = file_get_contents($file);
$raw_simple_data = json_decode($string, true);

$transactions = array();
foreach($raw_simple_data['transactions'] as $key => $raw_transaction){
	$transactions[$key]['id'] = $raw_transaction['uuid'];
	$transactions[$key]['date'] = $data->time($raw_transaction['times']['when_recorded']);
	$transactions[$key]['last_modified'] = $data->time($raw_transaction['times']['last_modified']);
	$transactions[$key]['description'] = addslashes($raw_transaction['description']);
	$transactions[$key]['memo'] = addslashes($raw_transaction['memo']);
	// $transactions[$key]['memo'] = 'test';
	$transactions[$key]['category'] = addslashes($raw_transaction['categories'][0]['name']);
	$transactions[$key]['category_type'] = addslashes($raw_transaction['categories'][0]['folder']);
	$transactions[$key]['transaction_type'] = $raw_transaction['bookkeeping_type'];
	$transactions[$key]['amount'] = $data->dollar($raw_transaction['amounts']['amount']);
	$transactions[$key]['running_balance'] = $data->dollar($raw_transaction['running_balance']);
}

foreach($transactions as $add_transaction){
	$database->add_transaction($add_transaction);
}



?>