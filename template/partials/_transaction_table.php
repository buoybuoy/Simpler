<table class="table">
	<tbody>

	<?php
	foreach($view->transactions as $transaction){

		$date = date("M j", strtotime($transaction['date']));
		$id = $transaction['id'];
		$budget_id = $transaction['budget_id'];
		$description = $transaction['description'];
		$amount = number_format($transaction['amount'], 2, '.', '');
		$label = null;

		if ($transaction['transaction_type'] == "debit"){
			$transaction_class = 'negative';
		} else {
			$transaction_class = 'positive';
		}

		if ($transaction['budget_id'] != 0){
			$label = '<span class="label label-default">' . $view->budget[$budget_id]['category'] . '</span>';
		}

		?>

		<tr>
			<td class="date">
				<?php echo $date; ?>
			</td>
			<td>
				<a href="#" 
					data-toggle="modal" 
					data-target="#transactionModal" 
					data-transactionid="<?php echo $id; ?>"  
					data-category="<?php echo $budget_id; ?>" 
					data-description="<?php echo $description; ?>" 
					data-amount="<?php echo $amount; ?>" 
				>
					<?php echo $description . ' ' . $label; ?>
				</a>
			</td>
			<td class="align-right <?php echo $transaction_class; ?>">
				<?php echo $amount; ?>
			</td>
		</tr>

	<?php } ?>

	</tbody>
</table>