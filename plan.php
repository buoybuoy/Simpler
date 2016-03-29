<?php

classes

	class config{
	// basic configuration for site constants, database credentials
		$dev
		// true/false depending on environment
		$base_url
		// base url for links
		$root_dir
		// root directory or files to be used for includes
		$db_host;
		$db_name;
		$db_port;
		$db_user;
		$db_pass;
		// database variables
		function dev_or_prod()
		// determine if dev or production environment, set $this->dev
		function set_error_reporting()
		// sets error reporting based on value of $dev
		function __construct()
			dev_or_prod()
			set_error_reporting()

		// todo: session control
		// todo: user management
	}

	class database extends config{
	// creates database connection to be used by controllers
		$db
		// database connection
		function raw_statement()
		// try/catch for database actions that don't require results
		function select($amount, $table, $stipluation)
		// select $amount from $table [$stipulation if not null]
		function insert($table, $array_of_values)
		// implode array into fields => values, inserts into table
		function __construct()
		// connect to database

		// todo: return self::connection or instance or whatever
		// todo: close connection
	}

	class model ($db, $dt){
	// gets/sets all data needed for controllers
	// most functions currently used in 'controller' class
		$db
		// database connection
		$transactions
		// all transactions ordered by date
		$budgeted_amounts
		// each budget category
			// limit
			// spent
			// remaining
			// transactions in category
		$all_categories
		$unused_categories
		$total_debit
		$total_credit
		$total_diff
		$account_balance

		function month_budgeted_amounts()
		// same as current controller "set_budget"
		function set_all_categories()
		// same as current controller file
		function set_transactions($start, $end)
		// get all transactions between $start and $end
		function get_account_balance()
		// get 'running_balance' from most recent transaction
		function balance_budget()
		// same
		function total_cashflow()
		// same

		function month_budget($start, $end)
			$this->set_all_categories();
			$this->month_budgeted_amounts();

		function month_activity($dt)
			$this->set_all_categories();


		function __construct($db)
			$this->db = $db

		// todo: all current functions using $this->year/month switch to use $dt->format
	}

	class controller{
	// base for all controllers
		$dt
		// datetime object needed by model

		function set_date($_GET)
		// set $dt with GET values
		function __construct($_GET)
			set_date($_GET)
	}

	$index = new controller($_GET);
		$model = new model($database->db);
		// check if 'budget' or 'activity'
		$model->month_budget($start, $end)

	$action = new controller();

	$upload = new controller();

	class view{
	// all functions use global $model
	}
