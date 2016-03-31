<?php

class model{

	protected $db;

	function __construct($db){
		$this->db = $db;
	}

	// gets all budget categories, not time-sensitive. ALL CATEGORIES
	function get_all_categories(){
		$categories = $this->db->select('*','budget_categories', null);
		$all_categories = array();
		foreach ($categories as $category){
			$all_categories[$category['id']] = $category['name'];
		}
		return $all_categories;
	}

	// get all budgeted amounts for month and year
	function get_budgeted_amounts($month, $year){
		$budgeted_amounts = array();
		$categories = $this->get_all_categories();
		$raw_budgeted_amounts = $this->db->select('*','budgeted_amounts', "WHERE `month`=$month AND `year`=$year ORDER BY `amount` DESC");
		foreach ($raw_budgeted_amounts as $budgeted_amount){
			$_id = $budgeted_amount['budget_category_id'];
			$budgeted_amounts[$_id] = array(
				'category_name'			=> 	$categories[$_id],
				'budgeted_amount_id'	=>	$budgeted_amount['id'],
				'month' 				=> 	$budgeted_amount['month'],
				'year' 					=> 	$budgeted_amount['year'],
				'limit'					=> 	$budgeted_amount['amount'],
				'spent'					=> 	0,
				'remaining'				=> 	$budgeted_amount['amount'],
				'transactions'			=>	array()
			);
		}
		unset($budgeted_amounts[0]);
		$budgeted_amounts[0] = array(
			'category_name'			=> 	'uncategorized',
			'budgeted_amount_id'	=>	0,
			'month' 				=> 	$month,
			'year' 					=> 	$year,
			'limit'					=> 	0,
			'spent'					=> 	0,
			'remaining'				=> 	0,
			'transactions'			=>	array()
		);
		return $budgeted_amounts;
	}

	function get_month_transactions($month, $year){
		$transactions = array();
		$raw_transactions = $this->db->select('*','transactions', "WHERE `budget_month` = $month AND `budget_year` = $year ORDER BY `date` DESC");
		foreach($raw_transactions as $raw_transaction){
			$transactions[$raw_transaction['id']] = $raw_transaction;
		}
		return $transactions;
	}

	function categorize_transactions($budgeted_amounts, $transactions){
		foreach ($transactions as $transaction){
			if (!array_key_exists($transaction['budget_category_id'], $budgeted_amounts)){
				$transaction['budget_category_id'] = 0;
			}
			$budgeted_amounts[ $transaction['budget_category_id'] ]['transactions'][ $transaction['id'] ] = $transaction;
			if ($transaction['transaction_type'] == 'debit'){
				$budgeted_amounts[ $transaction['budget_category_id'] ]['spent'] += $transaction['amount'];
			}
		}
		foreach ($budgeted_amounts as $key => $budgeted_amount){
			$budgeted_amounts[$key]['remaining'] = $budgeted_amount['limit'] - $budgeted_amount['spent'];
		}
		return $budgeted_amounts;
	}

	// returns running_balance of the last transaction of the month and year given
	function get_account_balance($month, $year){
		$dt = DateTime::createFromFormat('d n Y', 15 . ' ' . $month . ' ' . $year);
		$month = $dt->format('Y-m-d');
		$transaction = $this->db->select('*', 'transactions', "WHERE MONTH(`date`)=MONTH('$month') ORDER by `date` DESC LIMIT 1");
		$balance = $transaction[0]['running_balance'];
		return $balance;
	}

	// not converted due to necessity
	//
	// function total_cash_flow(){
	// 	foreach ($this->transactions as $transaction){
	// 		if ($transaction['transaction_type'] == 'debit'){
	// 			$this->total_debit = $this->total_debit + $transaction['amount'];
	// 		} else {
	// 			$this->total_credit = $this->total_credit + $transaction['amount'];
	// 		}
	// 	}
	// 	$this->total_diff = $this->total_credit - $this->total_debit;
	// }

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