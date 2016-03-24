<?php

/**
* The controller is the heart of the application. Functionality is based solely around the given month and year, 
* setting the base for what information to get and what information to set
*/

class controller extends database {

	public $dt;
	public $year;
	public $month;

	public $transactions;
	public $budgeted_amounts;

	public $all_categories;
	public $unused_categories;

	public $total_debit;
	public $total_credit;
	public $total_diff;

	public $page;

	function __construct($get){
		parent::__construct();	
		$this->set_date($get);
		$this->set_page($get);
		$this->set_all_categories();
		$this->set_budget();
		$this->transactions = $this->select('*','transactions', "WHERE `budget_month` = $this->month AND `budget_year` = $this->year ORDER BY `date` DESC");
		$this->total_cash_flow();
		$this->balance_budget();
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

	function set_page($get){
		if (isset($get['p'])){
			$this->page = $get['p'];
		} else {
			$this->page = 'activity';
		}
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
			$_id = $budgeted_amount['category_id'];
			$this->budgeted_amounts[$_id] = array(
				'category_name'			=> 	$this->all_categories[$_id],
				'budgeted_amount_id'	=>	$budgeted_amount['id'],
				'month' 				=> 	$budgeted_amount['month'],
				'year' 					=> 	$budgeted_amount['year'],
				'limit'					=> 	$budgeted_amount['amount'],
				'spent'					=> 	0,
				'remaining'				=> 	$budgeted_amount['amount']
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
			'remaining'				=> 	0
		);
		unset($this->unused_categories[0]);
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
		}
		foreach($this->budgeted_amounts as $key => $budget){
			$remaining = $budget['limit'] - $budget['spent'];
			$this->budgeted_amounts[$key]['remaining'] = $remaining;
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

	function add_category($name){
		$values = array('name' => $name);
	    $this->insert('budget_categories', $values);
	}

	function update_budget($post){

		if(!empty($post['new_category_name']) && !empty($post['new_category_amount'])){
			$name = $post['new_category_name'];
			$amount = $post['new_category_amount']; 	
			$this->add_category($name);
			$new_category = $this->select('*', 'budget_categories', "ORDER BY `id` DESC LIMIT 1");
			$post[ $new_category[0]['id'] ] = $amount;
		}
		unset($post['new_category_name']);
		unset($post['new_category_amount']);

		foreach($post as $category_id => $amount){
			$new_entry = array(
				'category_id' => $category_id,
				'amount' => $amount,
				'month' => $this->month,
				'year' => $this->year
			);
			$existing_amount = $this->select('*', 'budgeted_amounts', "WHERE `category_id` = $category_id AND `month` = $this->month AND `year` = $this->year LIMIT 1");
			if (!empty($existing_amount[0])){
				$new_entry['id'] = $existing_amount[0]['id'];
			}
			$this->update_budgeted_amount($new_entry);
		}
	}

	function update_budgeted_amount($post){
		$table = 'budgeted_amounts';
		extract($post);
		if (isset($id)){
			$sql = "UPDATE $table SET `amount` = $amount WHERE `id` = $id LIMIT 1";
		} else{
			$sql = "INSERT INTO {$table} (`category_id`, `amount`, `month`, `year`) VALUES('$category_id', '$amount', '$month', '$year')";
		}
	    $this->raw_statement($sql);
	}

	function update_transaction($post){
		$table = 'transactions';
		extract($post);
		$_dt = $this->dt;

		if (isset($budget_category_id)){
			if ($budget_month == 'next' OR $budget_month == 'prev'){
				if ($budget_month == 'next'){
					$offset = 1;
				} elseif ($budget_month == 'prev'){
					$offset = -1;
				}

				$_dt->modify('first day of' . $offset . ' month');
				$budget_month = $_dt->format('m');
				$budget_year = $_dt->format('Y');
			}
		    $sql = "UPDATE {$table} SET `budget_category_id`='$budget_category_id', `budget_month`=$budget_month, `budget_year`=$budget_year WHERE `id`='$id'";
		    $this->raw_statement($sql);
		}

		if (isset($create_rule) && $create_rule == true){
			
		}
	}

	// expects keyed array with 'trigger_type', 'trigger', 'budget_categories_id'
	function add_trigger($array){
		$this->insert('category_triggers', $array);
	}

}