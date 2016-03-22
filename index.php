<?php 

include('include/config.class.php');
include('include/database.class.php');
include('include/view.class.php');

include('template/partials/_dochead.php');
include('template/partials/_nav.php');
include('template/partials/_titlebar.php');


?>

<div class="container">
	<div class="row">
		<div class="col-xs-8">
			<table class="table">
				<tbody>

				<?php

				foreach($view->transactions as $transaction){
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
		<div class="col-xs-4 right-aside">
			<?php include('template/partials/_rightaside.php'); ?>
		</div>
	</div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/app.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>