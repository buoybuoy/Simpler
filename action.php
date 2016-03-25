<?php

include('include/validation.class.php');
include('include/action.class.php');

$referer = $config->base_url . '?' . $_SERVER['QUERY_STRING'];

$action = new action($_POST, $_GET, $referer);

