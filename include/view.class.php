<?php

require_once('controller.class.php');

class view extends controller {

	public $title;

	public $action_page;

	function __construct($get){
		parent::__construct($get);
		$this->title = $this->dt->format('F Y');
		$this->action_page = 'action.php?' . $_SERVER['QUERY_STRING'];
	}

	function link_relative_month($offset){
		global $config;
		$dt = DateTime::createFromFormat('n Y', $this->month . ' ' . $this->year);
		$dt->modify('first day of' . $offset . ' month');
		$_month = $dt->format('m');
		$_year = $dt->format('Y');
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

	function diff_class(){
		if ($this->total_diff < 0){
			$diff_class = 'negative';
		} else {
			$diff_class = 'positive';
		}
		return $diff_class;
	}

	function is_page_active($request_page){
		if ($this->page == $request_page){
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
