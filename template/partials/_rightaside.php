<?php
if ($view->page == 'activity'){ ?>

	<h3>Total</h3>
	<h4 class="positive">+ <?php echo $view->total_credit;?></h4>
	<h4 class="negative">- <?php echo $view->total_debit;?></h4>
	<hr>
	<h4 class="<?php echo $view->diff_class();?> "> <?php echo $view->total_diff; ?> </h4>

<?php } elseif ($view->page == 'budget'){ ?>

	<h3>Budget</h3>
	<table class="table">
	<tbody>
	<?php foreach ($view->budget as $category){
		echo '<tr>';
		echo '<td>' . $category['category'] . '</td><td>$' . $category['spent'] . ' spent</td><td>$' . $category['remaining'] . ' left</td>';
		echo '</tr>';
	} ?>
	</tbody>
	</table>
	<form class="form-inline" action="action.php" method="post">
		<div class="form-group">
			<input type="hidden" name="month" value="<?php echo $view->month; ?>">
			<input type="hidden" name="year" value="<?php echo $view->year; ?>">
			<input type="text" class="form-control" placeholder="Category" name="category_name">
			<input type="text" class="form-control" placeholder="Amount" name="amount">
		</div>
		<button type="submit" class="btn btn-default">Add</button>
	</form>

<?php } ?>