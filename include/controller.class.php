<?php

class controller extends database {

	public $dt;
	public $year;
	public $month;

	public $transactions;
	public $budget;

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
		$this->transactions = $this->select('*','transactions', "WHERE (MONTH(date) = $this->month AND YEAR(date) = $this->year) OR (budget_month = $this->month AND budget_year = $this->year) ORDER BY `date` DESC");
		$this->total_cash_flow();
		$this->balance_budget();
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

	function set_budget(){
		$this->budget = array();
		$budgeted_amounts = $this->select('*','budgeted_amounts', "WHERE `month`=$this->month AND `year`=$this->year ORDER BY `amount` DESC");
		foreach ($budgeted_amounts as $budgeted_amount){
			$budget_id = $budgeted_amount['id'];
			$this->budget[$budget_id] = array(
				'month' 		=> 		$budgeted_amount['month'],
				'year' 			=> 		$budgeted_amount['year'],
				'category_id' 	=> 		$budgeted_amount['category_id'],
				'category' 		=> 		$this->all_categories[$budgeted_amount['category_id']],
				'limit'			=> 		$budgeted_amount['amount'],
				'spent'			=> 		0,
				'remaining'		=> 		$budgeted_amount['amount']
			);
			unset($this->unused_categories[$budgeted_amount['category_id']]);
		}
	}

	function set_all_categories(){
		$categories = $this->select('*','categories', null);
		$this->all_categories = array();
		foreach ($categories as $category){
			$this->all_categories[$category['id']] = $category['name'];
		}
		$this->unused_categories = $this->all_categories;
	}

	function add_category($name){
		$table = 'categories';
	    $sql = "INSERT INTO {$table} (`name`) VALUES ('$name')";
	    $this->raw_statement($sql);
	}

	function update_budget($post){
		$table = 'budgeted_amounts';
		$fields = '`' . implode('`,`', array_keys($post)) . '`';
		$values = "'" . implode("','", $post) . "'";
		extract($post);
	    $sql = "INSERT INTO {$table} ($fields) VALUES($values) ON DUPLICATE KEY UPDATE
		    `amount` = '$amount'
		";
	    $this->raw_statement($sql);
	}

	function update_transaction($post){
		$table = 'transactions';
		extract($post);
		if ($budget_id == 'uncategorized'){
			$sql = "UPDATE {$table} SET `budget_id`=NULL, `budget_month`=NULL, `budget_year`=NULL WHERE `id`='$id'";
		} else {
	    	$sql = "UPDATE {$table} SET `budget_id`='$budget_id', `budget_month`=$budget_month, `budget_year`=$budget_year WHERE `id`='$id'";
	    }
	    $this->raw_statement($sql);
	}

	function balance_budget(){
		foreach($this->transactions as $transaction){
			if (isset($transaction['budget_id'])){
				if ($transaction['transaction_type'] == 'debit'){
					$this->budget[$transaction['budget_id']]['spent'] += $transaction['amount'];
				} else {
					$this->budget[$transaction['budget_id']]['spent'] -= $transaction['amount'];
				}
			}
		}
		foreach($this->budget as $key => $budget){
			$remaining = $budget['limit'] - $budget['spent'];
			$this->budget[$key]['remaining'] = $remaining;
		}
	}

}