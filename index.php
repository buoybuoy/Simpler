<?php 
error_reporting(E_ALL);
include('include/include.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> </title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
<table>
<tbody>
<?php

foreach($transactions as $transaction){
	$amount = round($transaction['amounts']['cleared']/10000, 2);
	$balance = round($transaction['running_balance']/10000, 2);
	echo '<tr>';
	echo '<td>' . $transaction['description'] . '</td>';
	echo '<td>' . $amount . '</td>';
	echo '<td>' . $balance . '</td>';
	echo '</tr>';
}

?>
</tbody>
</table>

<?php
echo '<pre>';
var_dump($transactions); ?>












<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/app.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>