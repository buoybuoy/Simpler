<?php

class view{

	// public $page;
	// public $title;
	// public $action_page;
	// public $ajax;

	function __construct(){
		// $this->set_page($get);
		// $this->set_ajax($get);
		// $this->title = $this->dt->format('F Y');
		// $this->action_page = 'action.php?' . $_SERVER['QUERY_STRING'];
	}

	// function load_partial($name){
	// 	global $config;
	// 	$partial = $config->root_dir . 'views/partials/_' . $name . '.php';
	// 	if (file_exists($partial)){
	// 		require($partial);
	// 	}
	// }

	// function set_page($get){
	// 	if (isset($get['p'])){
	// 		$this->page = $get['p'];
	// 	} else {
	// 		$this->page = 'activity';
	// 	}
	// }

	// function set_ajax($get){
	// 	if (isset($get['ajax']) AND $get['ajax'] == true){
	// 		$this->ajax = true;
	// 	} else {
	// 		$this->ajax = false;
	// 	}
	// }

	function link_relative_month($month, $year, $offset){
		global $config;
		$dt = DateTime::createFromFormat('n Y', $month . ' ' . $year);
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

		$link_location = $config->base_url . 'budget/' . $_year . '/' . $_month;
		// figure out how to handle referal page above
		
		$tag = '<a href="' . $link_location . '" class="month_nav ' . $_class . '">' . $_text . '</a>';
		return $tag;
	}

	function title($month, $year){
		$dt = DateTime::createFromFormat('n Y', $month . ' ' . $year);
		return $dt->format('F Y');
	}

	// function diff_class(){
	// 	if ($this->total_diff < 0){
	// 		$diff_class = 'negative';
	// 	} else {
	// 		$diff_class = 'positive';
	// 	}
	// 	return $diff_class;
	// }

	// function is_page_active($request_page){
	// 	if ($this->page == $request_page){
	// 		return 'active';
	// 	} else {
	// 		return;
	// 	}
	// }

	// function page_link($page){
	// 	global $config;
	// 	$link_location = $config->base_url . '?m=' . $this->month . '&y=' . $this->year . '&p=' . $page;
	// 	return $link_location;
	// }

	// function load_template(){
	// 	global $config;
	// 	$template = $config->root_dir . 'template/' . $this->page . '.php';
	// 	if (file_exists($template)){
	// 		ob_start();
	// 		require($template);
	// 		echo ob_get_clean();
	// 	}
	// }


}