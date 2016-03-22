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
	<?php foreach ($view->budget as $category){
		echo '<tr>';
		echo '<td>' . $category['category'] . '</td><td>$' . $category['spent'] . ' spent</td><td>$' . $category['remaining'] . ' left</td>';
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