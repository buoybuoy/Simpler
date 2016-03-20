<?php

include('config.class.php');
include('datahandler.class.php');

$filename = 'test_3-20-16-short.json';
$file = $config->root_dir . 'data/' . $filename;
$string = file_get_contents($file);
$raw_simple_data = json_decode($string, true);

$transactions = array();
foreach($raw_simple_data['transactions'] as $key => $transaction){
	$transactions[$key] = $dataHandler->arrayDenester($transaction);
}
echo '<pre>';
var_dump($transactions);
var_dump($raw_simple_data);
die();

?>