<div class="modal fade" id="budgetModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="description">Edit Budget </h4>
			</div>
			<div class="modal-body">
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
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>