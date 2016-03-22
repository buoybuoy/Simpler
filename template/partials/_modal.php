<div class="modal fade" id="transactionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="description">Transaction </h4>
			</div>
			<form action="<?php echo $view->action_page; ?>" method="post" autocomplete="off">
				<input type="hidden" name="action" value="update_transaction">
				<input type="hidden" name="id" id="id" value="placeholder">
				<input type="hidden" name="budget_month" value="<?php echo $view->month; ?>">
				<input type="hidden" name="budget_year" value="<?php echo $view->year; ?>">
				<div class="modal-body">
					<h5>Spend From</h5>
					<fieldset class="form-group">
						<select class="form-control" id="category" name="budget_id">
							<?php foreach($view->budget as $id => $budget) {
								echo '<option value="' . $id . '">' . $budget['category'] . '</option>';
							} ?>
							<option value="uncategorized">Uncategorized</option>
						</select>
					</fieldset>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>