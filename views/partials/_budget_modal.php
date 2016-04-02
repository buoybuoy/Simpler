<div class="modal fade" id="budgetModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="description">Edit Budget</h4>
			</div>
			<form class="form ajax-form" action="<?php echo $action_page; ?>" method="post" autocomplete="off" id="budgetForm">
				<input type="hidden" name="action" value="update_budget">
				<div class="modal-body">
					<table class="table">
						<tbody>
							<?php if(count($budgeted_amounts) > 1){ ?>
								<thead>
									<th>Edit Existing Categories</th>
								</thead>
								<?php foreach ($budgeted_amounts as $key => $category){ if($key != 0){?>
									<tr>
										<td><?php echo $category['category_name'] ?></td>
										<td><input type="text" class="form-control table-input" value="<?php echo $category['limit']; ?>" name="<?php echo $key; ?>"></td>
									</tr>
							<?php }}} ?>
								<thead>
									<th>Add New Budget Category</th>
								</thead>
								<?php if (!empty($unused_categories)) { foreach ($unused_categories as $key => $category){ ?>
									<tr id="<?php echo $key; ?>">
										<td><?php echo $category ?></td>
										<td><input type="text" class="form-control table-input" placeholder="Amount" name="<?php echo $key; ?>"></td>
										<td><a href="#" class="btn btn-danger delete-category" data-budgetcategoryid="<?php echo $key; ?>" data-url="<?php echo $action_page; ?>"><i class="fa fa-close"></i></a></td>
									</tr>
								<?php } } ?>
								<tr>
									<td><input type="text" class="form-control table-input" placeholder="New Category" name="new_category_name"></td>
									<td><input type="text" class="form-control table-input" placeholder="Amount" name="new_category_amount"></td>
								</tr>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary submit" data-toggle="modal" data-target="#budgetModal">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>