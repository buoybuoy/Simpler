<div class="modal fade" id="transactionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Edit Transaction </h4>
			</div>
			<form action="<?php echo $view->action_page; ?>" method="post" autocomplete="off">
				<input type="hidden" name="action" value="update_transaction">
				<input type="hidden" name="id" id="transactionId" value="placeholder">
				<input type="hidden" name="budget_year" value="<?php echo $view->year; ?>">
				<div class="modal-body">
					<table class="table">
						<thead>
							<th id="description">Placeholder</th>
							<th id="amount" class="align-right">0</th>
						</thead>
						<tbody>
							<tr>
								<td>
									Spend From
								</td>
								<td>
									<fieldset class="form-group">
										<select class="form-control" id="category" name="budget_id">
											<option value="0">Uncategorized</option>
											<?php foreach($view->budget as $id => $budget) {
												echo '<option value="' . $id . '">' . $budget['category'] . '</option>';
											} ?>
										</select>
									</fieldset>
								</td>
							</tr>
							<tr>
								<td>
									Move
								</td>
								<td>
									<fieldset class="form-group">
										<select class="form-control" id="budget_month" name="budget_month">
											<option value="prev">Previous Month</option>
											<option value="<?php echo $view->month; ?>" selected>Don't Move</option>
											<option value="next">Next Month</option>
										</select>
									</fieldset>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>