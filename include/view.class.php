<?php

class view extends database {

	public $dt;

	public $title;
	public $year;
	public $month;

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

	function month_transactions(){
		$stipulation = "MONTH(date) = $this->month AND YEAR(date) = $this->year";
		$transactions = $this->get_transactions($stipulation);
		return $transactions;
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

		$link_location = $config->base_url . '?m=' . $_month . '&y=' . $_year;
		$tag = '<a href="' . $link_location . '" class="month_nav ' . $_class . '">' . $_text . '</a>';
		return $tag;
	}


}

$view = new view($_GET);
