<?php

define("DB_HOST", "localhost");
define("DB_NAME", "simpler");
define("DB_PORT", "3306");
define("DB_USER", "simpler");
define("DB_PASS", "simpler");

try {
	$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT,DB_USER,DB_PASS);
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$db->exec("SET NAMES 'utf8'"); 
} catch (Exception $e) {
	$e->getTraceAsString();
	// echo "There was a problem connecting to the database;";
	echo $e;
	exit;
}

class database {

	function get_transactions($stipulation){
		global $db;
		try {
			if ($stipulation != null){
				$results = $db->query("SELECT * FROM `transactions` WHERE $stipulation ORDER BY `date` DESC");
			} else {
				$results = $db->query("SELECT * FROM `transactions` ORDER BY `date` DESC");
			}
		}catch( PDOException $e ) {
			$e->getMessage();
			echo $e;
		}
		$raw_results = $results->fetchAll(PDO::FETCH_ASSOC);
		return $raw_results;

	}

	function add_transaction($transaction){
		global $db;
		$table = 'transactions';

		$fields = '`' . implode('`,`', array_keys($transaction)) . '`';
		$values = "'" . implode("','", $transaction) . "'";
		extract($transaction);
	    $sql = "INSERT INTO {$table} ($fields) VALUES($values) ON DUPLICATE KEY UPDATE
	    `date` = '$date',
	    `last_modified` = '$last_modified',
	    `description` = '$description',
	    `memo` = '$memo',
	    `category` = '$category',
	    `transaction_type` = '$transaction_type',
	    `amount` = '$amount',
	    `running_balance` = '$running_balance'
	    ";
	    $this->raw_statement($sql);
	}

	function raw_statement($sql){
		global $db;
		try {
			$results = $db->prepare($sql);
			$results->execute();
		}catch( Exception $e ) {
			$e->getMessage();
			echo $e;
			die();
		}
	}

	function update_transaction($transaction){

	}

	function delete_transaction($transaction_id){

	}


}

$database = new database;

