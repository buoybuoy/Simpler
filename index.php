<?php 

include('include/config.class.php');
include('include/database.class.php');
include('include/controller.class.php');
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
					echo '<td>';
					echo '<a href="#" data-toggle="modal" data-target="#transactionModal" data-transaction="'. $transaction['id'] . '">';
					echo $transaction['description'] . '</a></td>';
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


<div class="modal fade" id="transactionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Transaction </h4>
      </div>
      <div class="modal-body">
      	<h5 class="transaction" id="transactionID">something</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/app.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>