<?php 

include('include/include.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> </title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
<div class="container">
	<div class="row">
		<div class="center">
			<h1>Simpl<em>er</em></h1>
		</div>
	</div>
	<div class="row">
		<div class="center">
			<h3><?echo $title;?></h3>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-8 col-xs-offset-2">
			<table class="table">
				<tbody>

				<?php

				foreach($transactions as $transaction){
					echo '<tr>';
					echo '<td class="date">' . date("M j", strtotime($transaction['date'])) . '</td>';
					echo '<td>' . $transaction['description'] . '</td>';
					if ($transaction['transaction_type'] == "debit"){
						echo '<td class="align-right negative">' . number_format($transaction['amount'], 2, '.', '') . '<span></td>';
					} else {
						echo '<td class="align-right positive transaction_amount">+ ' . number_format($transaction['amount'], 2, '.', '') . '</td>';
					}
					echo '</tr>';
				}

				?>

				</tbody>
			</table>
		</div>
	</div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/app.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>