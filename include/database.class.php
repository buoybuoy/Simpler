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
				$results = $this->db->query("SELECT $amount FROM `$table` WHERE $stipulation ORDER BY `date` DESC");
			} else {
				$results = $this->db->query("SELECT $amount FROM `$table` ORDER BY `date` DESC");
			}
		}catch( PDOException $e ) {
			echo $e->getMessage();
			exit;
		}
		return $results->fetchAll(PDO::FETCH_ASSOC);

	}
}

