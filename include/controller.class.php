<?php

class controller extends database {

	public $dt;
	public $year;
	public $month;

	public $transactions;
	public $budget;

	public $all_categories;
	public $used_categories;
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
		$this->transactions = $this->select('*','transactions', "MONTH(date) = $this->month AND YEAR(date) = $this->year ORDER BY `date` DESC");
		$this->total_cash_flow();
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
		$budgeted_amounts = $this->select('*','budgeted_amounts', "`month` = $this->month AND `year` = $this->year ORDER BY `amount` DESC");
		foreach ($budgeted_amounts as $budgeted_amount){
			$budget_id = $budgeted_amount['id'];
			$this->budget[$budget_id] = array(
				'month' 		=> 		$budgeted_amount['month'],
				'year' 			=> 		$budgeted_amount['year'],
				'category_id' 	=> 		$budgeted_amount['category_id'],
				'category' 		=> 		$this->all_categories[$budgeted_amount['category_id']]['name'],
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

	// function add_budgeted_amount($budget_array){
	// 	$table = 'transactions';
	// 	$fields = '`' . implode('`,`', array_keys($transaction)) . '`';
	// 	$values = "'" . implode("','", $transaction) . "'";
	// 	extract($transaction);
	//     $sql = "INSERT INTO {$table} ($fields) VALUES($values) ON DUPLICATE KEY UPDATE
	// 	    `date` = '$date',
	// 	    `last_modified` = '$last_modified',
	// 	    `raw_description` = '$raw_description',
	// 	    `description` = '$description',
	// 	    `memo` = '$memo',
	// 	    `category` = '$category',
	// 	    `transaction_type` = '$transaction_type',
	// 	    `amount` = '$amount',
	// 	    `running_balance` = '$running_balance'
	// 	";
	//     $this->raw_statement($sql);
	// }
	// }

}