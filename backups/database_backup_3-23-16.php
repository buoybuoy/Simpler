CREATE TABLE `budget_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

CREATE TABLE `budgeted_amounts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `amount` int(20) DEFAULT NULL,
  `month` int(10) DEFAULT NULL,
  `year` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

CREATE TABLE `category_triggers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `trigger_type` varchar(20) NOT NULL DEFAULT '',
  `trigger` varchar(250) NOT NULL DEFAULT '',
  `budget_categories_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `transactions` (
  `id` varchar(50) NOT NULL DEFAULT '',
  `date` datetime DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `raw_description` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `memo` varchar(500) DEFAULT NULL,
  `category_type` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `transaction_type` varchar(15) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `running_balance` float DEFAULT NULL,
  `budget_id` varchar(20) DEFAULT '0',
  `budget_month` int(5) DEFAULT NULL,
  `budget_year` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;