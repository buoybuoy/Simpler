<?php

require_once('controller.class.php');

class view extends controller {

	public $page;
	public $title;
	public $action_page;
	public $ajax;

	function __construct($get){
		parent::__construct($get);
		$this->set_page($get);
		$this->set_ajax($get);
		$this->title = $this->dt->format('F Y');
		$this->action_page = 'action.php?' . $_SERVER['QUERY_STRING'];
		$this->load_template();
	}

	function set_page($get){
		if (isset($get['p'])){
			$this->page = $get['p'];
		} else {
			$this->page = 'activity';
		}
	}

	function set_ajax($get){
		if (isset($get['ajax']) AND $get['ajax'] == true){
			$this->ajax = true;
		} else {
			$this->ajax = false;
		}
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

	function load_template(){
		global $config;
		$template = $config->root_dir . 'template/' . $this->page . '.php';
		if (file_exists($template)){
			ob_start();
			require($template);
			echo ob_get_clean();
		}
	}

	function load_partial($name, $load_on_ajax){
		global $config;
		$partial = $config->root_dir . 'template/partials/_' . $name . '.php';
		if (file_exists($partial)){
			if ($this->ajax == false){
				require($partial);
			} elseif ($load_on_ajax == true){
				require($partial);
			}
		}
	}


}

$view = new view($_GET);
