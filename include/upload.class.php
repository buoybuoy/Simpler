<?php

class upload extends database {

	public $file;


	function __construct($files){
		parent::__construct();
		$this->upload_file($files);
		$this->handle_data();
	}

	function upload_file($files){
		global $config;
		$timestamp = date('Y-m-d_H-i-s');
		$tempFile = $files['file']['tmp_name'];
		$targetPath = $config->root_dir . '/upload/data/';
		$targetFile = $targetPath . $timestamp . '_' . $_FILES['file']['name'];
		move_uploaded_file($tempFile,$targetFile);
		$this->file = $targetFile;
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

	function add_transaction($transaction){
		$table = 'transactions';
		$fields = '`' . implode('`,`', array_keys($transaction)) . '`';
		$values = "'" . implode("','", $transaction) . "'";
		extract($transaction);
	    $sql = "INSERT INTO {$table} ($fields) VALUES($values) ON DUPLICATE KEY UPDATE
		    `date` = '$date',
		    `last_modified` = '$last_modified',
		    `raw_description` = '$raw_description',
		    `description` = '$description',
		    `memo` = '$memo',
		    `category` = '$category',
		    `transaction_type` = '$transaction_type',
		    `amount` = '$amount',
		    `running_balance` = '$running_balance'
		";
		// echo '<pre>';
		// echo $sql;
		$this->raw_statement($sql);
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

	function handle_data(){
		$string = file_get_contents($this->file);
		// echo $string; exit;
		$raw_simple_data = json_decode($string, true);
		$transactions = $this->format_data($raw_simple_data);
		foreach($transactions as $transaction){
			$this->add_transaction($transaction);
		}
	}

}