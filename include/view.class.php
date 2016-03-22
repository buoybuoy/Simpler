<?php

class view extends database {

	public $dt;
	public $title;
	public $year;
	public $month;

	public $transactions;
	public $total_debit;
	public $total_credit;
	public $total_diff;

	public $page;

	function __construct($get){
		parent::__construct();
		$this->year = date("Y");
		$this->month = date("m");
		if (isset($get['y'])){
			$this->year = $get['y'];
		}
		if (isset($get['m'])){
			$this->month = $get['m'];
		}

		$this->dt = DateTime::createFromFormat('n Y', $this->month . ' ' . $this->year);
		$this->title = $this->dt->format('F Y');

		$stipulation = "MONTH(date) = $this->month AND YEAR(date) = $this->year";
		$this->transactions = $this->get_transactions($stipulation);
		$this->total_cash_flow();

		if (isset($get['p'])){
			$this->page = $get['p'];
		} else {
			$this->page = 'activity';
		}
	}

	function get_transactions($stipulation){
		try {
			if ($stipulation != null){
				$results = $this->db->query("SELECT * FROM `transactions` WHERE $stipulation ORDER BY `date` DESC");
			} else {
				$results = $this->db->query("SELECT * FROM `transactions` ORDER BY `date` DESC");
			}
		}catch( PDOException $e ) {
			$e->getMessage();
			echo $e;
			exit;
		}
		$raw_results = $results->fetchAll(PDO::FETCH_ASSOC);
		return $raw_results;

	}

	function link_relative_month($offset){
		global $config;
		$dt = DateTime::createFromFormat('n Y', $this->month . ' ' . $this->year);
		$interval = $offset . ' month';
		$dt->modify('first day of' . $offset . ' month');
		$_month = $dt->format('m');
		$_year = $dt->format('Y');
		$_name = $dt->format('F');
		if ($offset > 0){
			$_class = 'next';
			$_text = '<i class="fa fa-angle-right"></i>';
		} else {
			$_class = 'prev';
			$_text = '<i class="fa fa-angle-left"></i>';
		}

		$link_location = $config->base_url . '?m=' . $_month . '&y=' . $_year . '&p=' . $this->page;
		$tag = '<a href="' . $link_location . '" class="month_nav ' . $_class . '">' . $_text . '</a>';
		return $tag;
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

	function diff_class(){
		if ($this->total_diff < 0){
			$diff_class = 'negative';
		} else {
			$diff_class = 'positive';
		}
		return $diff_class;
	}

	function is_page_active($page){
		if ($this->page == $page){
			return 'active';
		} else {
			return;
		}
	}

	function page_link($page){
		global $config;
		$link_location = $config->base_url . '?m=' . $this->month . '&y=' . $this->year . '&p=' . $page;
		return $link_location;
	}


}

$view = new view($_GET);
