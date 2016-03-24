<div class="modal fade" id="budgetModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="description"><?php echo $view->title; ?></h4>
			</div>
			<form class="form" action="<?php echo $view->action_page; ?>" method="post" autocomplete="off">
				<input type="hidden" name="action" value="update_budget">
				<div class="modal-body">
					<table class="table">
						<tbody>
							<?php if(count($view->budgeted_amounts) > 1){ ?>
								<thead>
									<th>Edit Existing Categories</th>
								</thead>
								<?php foreach ($view->budgeted_amounts as $key => $category){ if($key != 0){?>
									<tr>
										<td><?php echo $category['category_name'] ?></td>
										<td><input type="text" class="form-control table-input" value="<?php echo $category['limit']; ?>" name="<?php echo $key; ?>"></td>
									</tr>
							<?php }}} ?>
								<thead>
									<th>Add New Budget Category</th>
								</thead>
								<?php foreach ($view->unused_categories as $key => $category){ ?>
									<tr>
										<td><?php echo $category ?></td>
										<td><input type="text" class="form-control table-input" placeholder="Amount" name="<?php echo $key; ?>"></td>
									</tr>
								<?php } ?>
								<tr>
									<td><input type="text" class="form-control table-input" placeholder="New Category" name="new_category_name"></td>
									<td><input type="text" class="form-control table-input" placeholder="Amount" name="new_category_amount"></td>
								</tr>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-default">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>