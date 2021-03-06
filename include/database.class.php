<?php

require_once('config.class.php');

class database extends config{

	public $db;

	function __construct(){
		try {
			$this->db = new PDO("mysql:host=" . $this->db_host . ";dbname=" . $this->db_name . ";port=" . $this->db_port,$this->db_user,$this->db_pass);
			$this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$this->db->exec("SET NAMES 'utf8'"); 
		} catch (Exception $e) {
			echo $e->getTraceAsString();
			exit;
		}
	}

	function raw_statement($sql){
		try {
			$results = $this->db->prepare($sql);
			$results->execute();
		}catch( Exception $e ) {
			echo $e->getMessage();
			exit;
		}
	}

	function select($amount,$table,$stipulation){
		try {
			if ($stipulation != null){
				$results = $this->db->query("SELECT $amount FROM `$table` $stipulation");
			} else {
				$results = $this->db->query("SELECT $amount FROM `$table`");
			}
		}catch( PDOException $e ) {
			echo $e->getMessage();
			exit;
		}
		return $results->fetchAll(PDO::FETCH_ASSOC);

	}

	function insert($table, $array_of_values){
		$fields = '`' . implode('`,`', array_keys($array_of_values)) . '`';
		$values = "'" . implode("','", $array_of_values) . "'";
	    $sql = "INSERT INTO {$table} ($fields) VALUES($values)";
	    $this->raw_statement($sql);
	}
}

$database = new database();