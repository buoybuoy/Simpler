<table class="table">
	<tbody>

	<?php
	foreach($view->transactions as $transaction){

		extract($transaction);
		$date = date("M j", strtotime($date));
		$amount = number_format($amount, 2, '.', '');
		$label = null;

		if ($transaction_type == "debit"){
			$transaction_class = 'negative';
		} else {
			$transaction_class = 'positive';
		}

		if ($budget_id != 0){
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
					data-date="<?php echo $date; ?>" 
					data-transactionid="<?php echo $id; ?>"
					data-rawdescription="<?php echo $raw_description; ?>"
					data-description="<?php echo $description; ?>"
					data-category="<?php echo $category; ?>"
					data-categorytype="<?php echo $category_type; ?>"
					data-budgetid="<?php echo $budget_id; ?>"
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