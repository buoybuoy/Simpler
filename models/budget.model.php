<?php

require_once($config->root_dir . '/models/model.class.php');

class budget extends model{

	public $month_budget;
	public $all_categories;
	public $unused_categories;
	public $account_balance;

	function __construct($db){
		parent::__construct($db);
	}

	function initialize_month_budget($month, $year){
		$this->month_budget = $this->categorize_transactions(
			$this->get_budgeted_amounts($month, $year),
			$this->get_month_transactions($month, $year)
		);
		$this->all_categories = $this->get_all_categories();	
		$this->unused_categories = $this->get_unused_categories($month, $year, $this->month_budget);
		$this->account_balance = $this->get_account_balance($month, $year);
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

	// gets all categories and compares against budgeted_amounts to unset all used categories
	// returns array of unused category ($budget_category_id => $name)
	function get_unused_categories($month, $year, $budgeted_amounts){
		$unused_categories = $this->get_all_categories();
		foreach($budgeted_amounts as $budget_category_id => $amount){
			unset($unused_categories[$budget_category_id]);
		}
		return $unused_categories;
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

	function get_transaction($id){
		$transaction = $this->db->select('*', 'transactions', "WHERE `id` = '$id' LIMIT 1");
		return $transaction[0];
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

	function add_category($category_name){
		$this->db->insert('budget_categories', array('name' => $category_name));
		$new_category = $this->db->select('*', 'budget_categories', "ORDER BY `id` DESC LIMIT 1");
		return $new_category[0];
	}

	function delete_category($category_id){
		$sql = "DELETE FROM budget_categories WHERE `id` = $category_id";
		$this->db->raw_statement($sql);
	}

	function update_budget($month, $year, $post){
		if(!empty($post['new_category_name']) && !empty($post['new_category_amount'])){
			$new_category = $this->add_category($post['new_category_name']);
			$post[$new_category['id']] = $post['new_category_amount'];
		}
		unset($post['new_category_name']);
		unset($post['new_category_amount']);
		foreach($post as $budget_category_id => $amount){
			$new_entry = array(
				'budget_category_id' => $budget_category_id,
				'amount' => intval($amount),
				'month' => $month,
				'year' => $year
			);
			$existing_amount = $this->db->select('*', 'budgeted_amounts', "WHERE `budget_category_id` = $budget_category_id AND `month` = $month AND `year` = $year LIMIT 1");
			if (!empty($existing_amount[0])){
				$new_entry['id'] = $existing_amount[0]['id'];
			}
			$this->update_budgeted_amount($new_entry);
		}
	}

	function update_budgeted_amount($new_entry){
		$table = 'budgeted_amounts';
		extract($new_entry);
		if (isset($id)){
			if ($amount == 0){
				$this->db->raw_statement("DELETE FROM $table WHERE `id` = $id LIMIT 1");
			} else {
				$this->db->raw_statement("UPDATE $table SET `amount` = $amount WHERE `id` = $id LIMIT 1");
			}
		} elseif($amount != 0){
			$this->db->raw_statement("INSERT INTO {$table} (`budget_category_id`, `amount`, `month`, `year`) VALUES('$budget_category_id', '$amount', '$month', '$year')");
		}
	}

	function update_transaction($month, $year, $post){
		$table = 'transactions';
		extract($post);
		if (isset($budget_category_id)){
			if ($budget_month == 'next' OR $budget_month == 'prev'){
				if ($budget_month == 'next'){
					$offset = 1;
				} elseif ($budget_month == 'prev'){
					$offset = -1;
				}
				$dt = DateTime::createFromFormat('d n Y', 15 . ' ' . $month . ' ' . $year);
				$dt->modify('first day of' . $offset . ' month');
				$budget_month = $dt->format('m');
				$budget_year = $dt->format('Y');
			}
		    $sql = "UPDATE {$table} SET `budget_category_id`='$budget_category_id', `budget_month`=$budget_month, `budget_year`=$budget_year WHERE `id`='$id'";
		    $this->db->raw_statement($sql);
		}
		if (isset($create_trigger) && $create_trigger == true){
			$transaction = $this->get_transaction($id);
			$trigger = array(
				'trigger_type' => $trigger_type,
				'trigger' => $transaction[$trigger_type],
				'budget_category_id' => $budget_category_id
			);
			$this->add_trigger($trigger);
		}
	}

	function add_trigger($array){
		extract($array);
		$existing_trigger = $this->db->select('*', 'category_triggers', "WHERE `trigger_type` = '$trigger_type' AND `trigger` = '$trigger'");
		if (!empty($existing_trigger[0])){
			$id = $existing_trigger[0]['id'];
			$sql = "UPDATE category_triggers SET `budget_category_id`='$budget_category_id' WHERE `id`='$id' LIMIT 1";
			$this->db->raw_statement($sql);
		} else {
			$this->db->insert('category_triggers', $array);
		}
		$this->evaluate_triggers();
	}

	function evaluate_triggers(){
		$all_triggers = $this->db->select('*', 'category_triggers', null);
		foreach($all_triggers as $single_trigger){
			extract($single_trigger);
			$sql = "UPDATE transactions SET `budget_category_id` = $budget_category_id WHERE `$trigger_type` = '$trigger' AND `budget_category_id` = 0";
			$this->db->raw_statement($sql);
		}
	}

	function clean_table($table){
		$dirty_table = $this->db->select('*', $table, null);
		foreach ($dirty_table as $dirty_row){
			$category_id = $dirty_row['budget_category_id'];
			$transaction_id = $dirty_row['id'];
			$all_categories = $this->get_all_categories();
			if ($table === 'transactions'){
				$sql = "UPDATE $table SET `budget_category_id` = 0 WHERE `id` = '$transaction_id';";
			} else {
				$sql = "DELETE from $table WHERE `budget_category_id` = $category_id;";
			}
			if(!array_key_exists($category_id, $all_categories)){
				$this->db->raw_statement($sql);
			}
		}
	}

	function clean_database(){
		$this->clean_table('budgeted_amounts');
		$this->clean_table('transactions');
		$this->clean_table('category_triggers');
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

	// function budgeted_per_day(){
	// 	$total_budgeted_amount = 0;
	// 	foreach ($this->budgeted_amounts as $budgeted_amount){
	// 		$total_budgeted_amount += $budgeted_amount['limit'];
	// 	}
	// 	$per_day = round($total_budgeted_amount/30.42, 2);
	// 	return $per_day;
	// }

	// function zero_date(){
	// 	$balance = $this->get_account_balance();
	// 	$per_day = $this->budgeted_per_day();
	// 	if ($per_day == 0){
	// 		return 'never';
	// 	} else {
	// 		$days_left = round($balance/$per_day, 0);
	// 		$date = new DateTime('now');
	// 		$zero_date = $date->modify('+' . $days_left . ' days');
	// 		return $zero_date->format('M d, Y');
	// 	}
	// }

	

}