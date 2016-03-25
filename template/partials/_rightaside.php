<?php

if ($view->page == 'activity'){ ?>

	<h3>Total</h3>
	<h4 class="positive">+ <?php echo $view->total_credit;?></h4>
	<h4 class="negative">- <?php echo $view->total_debit;?></h4>
	<hr>
	<h4 class="<?php echo $view->diff_class();?> "> <?php echo $view->total_diff; ?> </h4>

<?php } elseif ($view->page == 'budget'){ ?>

	<h3>
		<a href="#" data-toggle="modal" data-target="#budgetModal" class="hover-animate hover-animate-left">
			Budget <i class="fa fa-cog"></i>
		</a>
	</h3>
	<table class="table">
	<tbody>
	<?php foreach ($view->budgeted_amounts as $key => $budgeted_amount){
		if ($key == 0){
			echo '<tr class="small">';
			echo '<td><i>' . $budgeted_amount['category_name'] . '</i></td><td><i>$' . $budgeted_amount['spent'] . '</i></td><td></td>';
		} else {
			echo '<tr>';
			echo '<td>' . $budgeted_amount['category_name'] . '</td><td>$' . $budgeted_amount['spent'] . ' spent</td><td>$' . $budgeted_amount['remaining'] . ' left</td>';
		}
		echo '</tr>';
	} ?>
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