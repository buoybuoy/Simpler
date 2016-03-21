<?php

class database {

	protected $db;
	protected $db_host = "localhost";
	protected $db_name = "simpler";
	protected $db_port = "3306";
	protected $db_user = "simpler";
	protected $db_pass = "simpler";

	function __construct(){
		try {
			$this->db = new PDO("mysql:host=" . $this->db_host . ";dbname=" . $this->db_name . ";port=" . $this->db_port,$this->db_user,$this->db_pass);
			$this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$this->db->exec("SET NAMES 'utf8'"); 
		} catch (Exception $e) {
			$e->getTraceAsString();
			// echo "There was a problem connecting to the database;";
			echo $e;
			exit;
		}
	}

	function raw_statement($sql){
		try {
			$results = $this->db->prepare($sql);
			$results->execute();
		}catch( Exception $e ) {
			$e->getMessage();
			echo $e;
			exit;
		}
	}

	function get_transactions($stipulation){
		try {
			if ($stipulation != null){
				$results = $this->db->query("SELECT * FROM `transactions` WHERE $stipulation ORDER BY `date` DESC");
			} else {
				$results = $this->db->query("SELECT * FROM `transactions` ORDER BY `date` DESC");
			}
		}catch( PDOException $e ) {
			$e->getMessage();
			echo $e;
			exit;
		}
		$raw_results = $results->fetchAll(PDO::FETCH_ASSOC);
		return $raw_results;

	}

	function add_transaction($transaction){
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


}

$database = new database;

