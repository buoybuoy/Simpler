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
	<hr>
	<h4>Add to Budget</h4>
	<table class="table">
	<tbody>
	<?php foreach ($view->unused_categories as $key => $unused_category){ ?>
		<tr>
			<form class="form-inline" action="<?php echo $view->action_page; ?>" method="post" autocomplete="off">
				<!-- <div class="form-group"> -->
					<input type="hidden" name="action" value="update_amount">
					<input type="hidden" name="category_id" value="<?php echo $key; ?>">
					<input type="hidden" name="month" value="<?php echo $view->month; ?>">
					<input type="hidden" name="year" value="<?php echo $view->year; ?>">
					<td><?php echo $unused_category ?></td>
					<td><input type="text" class="form-control table-input" id="amount" placeholder="Amount" name="amount"></td>
				<!-- </div> -->
				<td><button type="submit" class="btn btn-default">Add</button></td>
			</form>
		</tr>
	<?php } ?>
		<tr>
			<form class="form-inline" action="<?php echo $view->action_page; ?>" method="post" autocomplete="off">
				<!-- <div class="form-group"> -->
					<input type="hidden" name="action" value="update_amount">
					<input type="hidden" name="category_id" value="new">
					<input type="hidden" name="month" value="<?php echo $view->month; ?>">
					<input type="hidden" name="year" value="<?php echo $view->year; ?>">
					<td><input type="text" class="form-control" placeholder="New Category" name="category_name"></td>
					<td><input type="text" class="form-control table-input" id="amount" placeholder="Amount" name="amount"></td>
				<!-- </div> -->
				<td><button type="submit" class="btn btn-default">Add</button></td>
			</form>
		</tr>
	</tbody>
	</table>
	<!-- <form class="form-inline" action="action.php" method="post">
		<div class="form-group">
			<input type="hidden" name="action" value="add_category">
			<input type="text" class="form-control" placeholder="Category" name="category_name">
		</div>
		<button type="submit" class="btn btn-default">Add</button>
	</form> -->



<?php } ?>