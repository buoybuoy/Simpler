<?php

class model{

	protected $db;

	// public $dt;
	// public $year;
	// public $month;

	// public $transactions;
	// public $budgeted_amounts;

	// public $all_categories;
	// public $unused_categories;

	// public $total_debit;
	// public $total_credit;
	// public $total_diff;

	function __construct($db){
		$this->db = $db;

		// $this->set_date($get);
		// $this->set_all_categories();
		// $this->set_budget();
		// $this->set_transactions();
		// $this->total_cash_flow();
		// $this->balance_budget();
		// $this->get_account_balance();
	}

	function set_date($get){
		$this->year = date("Y");
		$this->month = date("m");
		if (isset($get['y'])){
			$this->year = $get['y'];
		}
		if (isset($get['m'])){
			$this->month = $get['m'];
		}
		$this->dt = DateTime::createFromFormat('n Y', $this->month . ' ' . $this->year);
	}

	function set_all_categories(){
		$categories = $this->select('*','budget_categories', null);
		$this->all_categories = array();
		foreach ($categories as $category){
			$this->all_categories[$category['id']] = $category['name'];
		}
		$this->unused_categories = $this->all_categories;
	}

	function set_budget(){
		$this->budgeted_amounts = array();
		$raw_budgeted_amounts = $this->select('*','budgeted_amounts', "WHERE `month`=$this->month AND `year`=$this->year ORDER BY `amount` DESC");
		foreach ($raw_budgeted_amounts as $budgeted_amount){
			$_id = $budgeted_amount['budget_category_id'];
			$this->budgeted_amounts[$_id] = array(
				'category_name'			=> 	$this->all_categories[$_id],
				'budgeted_amount_id'	=>	$budgeted_amount['id'],
				'month' 				=> 	$budgeted_amount['month'],
				'year' 					=> 	$budgeted_amount['year'],
				'limit'					=> 	$budgeted_amount['amount'],
				'spent'					=> 	0,
				'remaining'				=> 	$budgeted_amount['amount'],
				'transactions'			=>	array()
			);
			unset($this->unused_categories[$_id]);
		}
		unset($this->budgeted_amounts[0]);
		$this->budgeted_amounts[0] = array(
			'category_name'			=> 	'uncategorized',
			'budgeted_amount_id'	=>	0,
			'month' 				=> 	$this->month,
			'year' 					=> 	$this->year,
			'limit'					=> 	0,
			'spent'					=> 	0,
			'remaining'				=> 	0,
			'transactions'			=>	array()
		);
		unset($this->unused_categories[0]);
	}

	function set_transactions(){
		$this->transactions = array();
		$raw_transactions = $this->select('*','transactions', "WHERE `budget_month` = $this->month AND `budget_year` = $this->year ORDER BY `date` DESC");
		foreach($raw_transactions as $raw_transaction){
			$this->transactions[$raw_transaction['id']] = $raw_transaction;
		}
	}

	function balance_budget(){
		foreach($this->transactions as $key => $transaction){
			if (!array_key_exists($transaction['budget_category_id'], $this->budgeted_amounts)){
				$this->transactions[$key]['budget_category_id'] = 0; 
			}
		}
		foreach($this->transactions as $key => $transaction){
			extract($transaction);
			if ($transaction_type == 'debit'){
				$this->budgeted_amounts[$budget_category_id]['spent'] += $amount;
			}
			$this->budgeted_amounts[$budget_category_id]['transactions'][$id] = $transaction;
		}
		foreach($this->budgeted_amounts as $key => $budget){
			$remaining = $budget['limit'] - $budget['spent'];
			$this->budgeted_amounts[$key]['remaining'] = $remaining;
		}
	}

	function categorize_transactions(){
		foreach($this->budgeted_amounts as $key => $budget){
			$this->budgeted_amount[$key]['transactions'] = array();
		}
		foreach($this->transactions as $id => $transaction){
			// $this->categorized_transactions[ ]
		}
	}

	function total_cash_flow(){
		foreach ($this->transactions as $transaction){
			if ($transaction['transaction_type'] == 'debit'){
				$this->total_debit = $this->total_debit + $transaction['amount'];
			} else {
				$this->total_credit = $this->total_credit + $transaction['amount'];
			}
		}
		$this->total_diff = $this->total_credit - $this->total_debit;
	}

	function get_account_balance(){
		$last_transaction = $this->select('*', 'transactions', "ORDER by `date` DESC LIMIT 1");
		$balance = $last_transaction[0]['running_balance'];
		return $balance;
	}

	function budgeted_per_day(){
		$total_budgeted_amount = 0;
		foreach ($this->budgeted_amounts as $budgeted_amount){
			$total_budgeted_amount += $budgeted_amount['limit'];
		}
		$per_day = round($total_budgeted_amount/30.42, 2);
		return $per_day;
	}

	function zero_date(){
		$balance = $this->get_account_balance();
		$per_day = $this->budgeted_per_day();
		if ($per_day == 0){
			return 'never';
		} else {
			$days_left = round($balance/$per_day, 0);
			$date = new DateTime('now');
			$zero_date = $date->modify('+' . $days_left . ' days');
			return $zero_date->format('M d, Y');
		}
	}

	

}