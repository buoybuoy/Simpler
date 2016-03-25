<?php

require_once('controller.class.php');

class action extends controller {

	protected $post;
	protected $referer;
	protected $ajax;

	function __construct($post, $get, $referer){
		parent::__construct($get);
		$this->referer = $referer;
		$this->action($post);
		$this->set_all_categories();
		$this->clean_database();
		$this->redirect();
	}

	function action($post){
		global $validate;
		$this->post = $validate->escape($post);
		if (isset($post['ajax'])){
			$this->ajax = $post['ajax'];
			unset($post['ajax']);
		}
		if (isset($post['action'])){
			$action = $this->post['action'];
			unset($this->post['action']);
			if ($action == 'update_budget'){
				$this->update_budget();
			} elseif ($action == 'update_transaction'){
				$this->update_transaction();
			} elseif ($action == 'delete_category'){
				$this->delete_category();
			}
		}
	}

	function redirect($referer){
		header('Location:' . $this->referer . '&ajax=true');
	}

	function update_budget(){
		if(!empty($this->post['new_category_name']) && !empty($this->post['new_category_amount'])){
			$name = $this->post['new_category_name'];
			$amount = $this->post['new_category_amount']; 	
			$this->insert('budget_categories', array('name' => $name));
			$new_category = $this->select('*', 'budget_categories', "ORDER BY `id` DESC LIMIT 1");
			$this->post[ $new_category[0]['id'] ] = $amount;
		}
		unset($this->post['new_category_name']);
		unset($this->post['new_category_amount']);
		foreach($this->post as $budget_category_id => $amount){
			$new_entry = array(
				'budget_category_id' => $budget_category_id,
				'amount' => intval($amount),
				'month' => $this->month,
				'year' => $this->year
			);
			$existing_amount = $this->select('*', 'budgeted_amounts', "WHERE `budget_category_id` = $budget_category_id AND `month` = $this->month AND `year` = $this->year LIMIT 1");
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
				$this->raw_statement("DELETE FROM $table WHERE `id` = $id LIMIT 1");
			} else {
				$this->raw_statement("UPDATE $table SET `amount` = $amount WHERE `id` = $id LIMIT 1");
			}
		} elseif($amount != 0){
			$this->raw_statement("INSERT INTO {$table} (`budget_category_id`, `amount`, `month`, `year`) VALUES('$budget_category_id', '$amount', '$month', '$year')");
		}
	}

	function delete_category(){
		$id = $this->post['budget_category_id'];
		$sql = "DELETE FROM budget_categories WHERE `id` = $id";
		$this->raw_statement($sql);
	}

	function update_transaction(){
		$table = 'transactions';
		extract($this->post);
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
		if (isset($create_trigger) && $create_trigger == true){
			$trigger = array(
				'trigger_type' => $trigger_type,
				'trigger' => $this->transactions[$id][$trigger_type],
				'budget_category_id' => $budget_category_id
			);
			$this->add_trigger($trigger);
		}
	}

	// expects array with 'trigger_type', 'trigger', 'budget_category_id' keys
	function add_trigger($array){
		extract($array);
		$existing_trigger = $this->select('*', 'category_triggers', "WHERE `trigger_type` = '$trigger_type' AND `trigger` = '$trigger'");
		if (!empty($existing_trigger[0])){
			$id = $existing_trigger[0]['id'];
			$sql = "UPDATE category_triggers SET `budget_category_id`='$budget_category_id' WHERE `id`='$id' LIMIT 1";
			$this->raw_statement($sql);
		} else {
			$this->insert('category_triggers', $array);
		}
		$this->evaluate_triggers();
	}

	function evaluate_triggers(){
		$all_triggers = $this->select('*', 'category_triggers', null);
		foreach($all_triggers as $single_trigger){
			extract($single_trigger);
			$sql = "UPDATE transactions SET `budget_category_id` = $budget_category_id WHERE `$trigger_type` = '$trigger' AND `budget_category_id` = 0";
			$this->raw_statement($sql);
		}

	}

	function clean_transactions(){
		$table = 'transactions';
		$dirty_table = $this->select('*', $table, null);
		foreach ($dirty_table as $dirty_row){
			$category_id = $dirty_row['budget_category_id'];
			$transaction_id = $dirty_row['id'];
			$sql = "UPDATE $table SET `budget_category_id` = 0 WHERE `id` = '$transaction_id';";
			if(!array_key_exists($category_id, $this->all_categories)){
				$this->raw_statement($sql);
			}
		}
	}

	function clean_table($table){
		$dirty_table = $this->select('*', $table, null);
		foreach ($dirty_table as $dirty_row){
			$category_id = $dirty_row['budget_category_id'];
			$sql = "DELETE from $table WHERE `budget_category_id` = $category_id;";
			if(!array_key_exists($category_id, $this->all_categories) OR $category_id == 0){
				$this->raw_statement($sql);
			}
		}
	}

	function clean_database(){
		$this->clean_table('budgeted_amounts');
		$this->clean_transactions();
		$this->clean_table('category_triggers');
	}

}