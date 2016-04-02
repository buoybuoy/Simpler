<?php

class upload extends budget {

	function __construct($database){
		parent::__construct($database);
	}

	function upload_file($files){
		global $config;
		$timestamp = date('Y-m-d_H-i-s');
		$tempFile = $files['file']['tmp_name'];
		$targetPath = $config->root_dir . '/data/';
		$targetFile = $targetPath . $timestamp . '_' . $_FILES['file']['name'];
		move_uploaded_file($tempFile,$targetFile);
		$transactions = $this->get_uploaded_data($targetFile);
		$this->add_transactions($transactions);
	}

	function get_uploaded_data($file){
		$string = file_get_contents($file);
		$raw_simple_data = json_decode($string, true);
		$transactions = $this->format_data($raw_simple_data);
		return $transactions;
	}

	function dollar($amount){
		$formatted_amount = round($amount/10000, 2);
		return $formatted_amount;
	}

	function time($time){
		$new_time = $time/1000;
		$formatted_time = date("Y-m-d H:i:s", $new_time);
		return $formatted_time;
	}

	function format_data($raw_simple_data){
		$transactions = array();
		foreach($raw_simple_data['transactions'] as $key => $raw_transaction){
			if (!$raw_transaction['is_hold']){
				$dt = new DateTime($this->time($raw_transaction['times']['when_recorded']));

				$transactions[$key]['id'] = $raw_transaction['uuid'];
				$transactions[$key]['date'] = $this->time($raw_transaction['times']['when_recorded']);
				$transactions[$key]['last_modified'] = $this->time($raw_transaction['times']['last_modified']);
				$transactions[$key]['raw_description'] = addslashes($raw_transaction['raw_description']);
				$transactions[$key]['description'] = addslashes($raw_transaction['description']);
				$transactions[$key]['memo'] = addslashes($raw_transaction['memo']);
				$transactions[$key]['category'] = addslashes($raw_transaction['categories'][0]['name']);
				$transactions[$key]['category_type'] = addslashes($raw_transaction['categories'][0]['folder']);
				$transactions[$key]['transaction_type'] = $raw_transaction['bookkeeping_type'];
				$transactions[$key]['amount'] = $this->dollar($raw_transaction['amounts']['amount']);
				$transactions[$key]['running_balance'] = $this->dollar($raw_transaction['running_balance']);

				// run rules to determine budget_category_id

				$transactions[$key]['budget_category_id'] = 0;
				$transactions[$key]['budget_month'] = date_format($dt, 'm');
				$transactions[$key]['budget_year'] = date_format($dt, 'Y');
			}
		}
		//var_dump($transactions); die();
		return $transactions;
	}

}