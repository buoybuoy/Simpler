<div class="modal fade" id="transactionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="description">Transaction </h4>
			</div>
			<div class="modal-body">
				<table class="table">
					<thead>
						<th>Spend From</th>
					</thead>
					<tbody>
						<tr>
							<form action="<?php echo $view->action_page; ?>" method="post" autocomplete="off">
								<input type="hidden" name="action" value="update_transaction">
								<input type="hidden" name="id" id="id" value="placeholder">
								<input type="hidden" name="budget_month" value="<?php echo $view->month; ?>">
								<input type="hidden" name="budget_year" value="<?php echo $view->year; ?>">
								<td>
									<fieldset class="form-group">
										<select class="form-control" id="category" name="budget_id">
											<option value="uncategorized">Uncategorized</option>
											<?php foreach($view->budget as $id => $budget) {
												echo '<option value="' . $id . '">' . $budget['category'] . '</option>';
											} ?>
										</select>
									</fieldset>
								</td>
								<td>
									<button type="submit" class="btn btn-default">Save</button>
								</td>
							</form>
						</tr>
						<thead>
							<th>Move transaction</th>
						</thead>
						<tr>
							<td>
								<form class="form-inline" action="<?php echo $view->action_page; ?>" method="post" autocomplete="off">
									<input type="hidden" name="action" value="update_transaction">
									<input type="hidden" name="id" value="<?php echo $key; ?>">
									<input type="hidden" name="budget_month" value="prev">
									<input type="hidden" name="budget_year" value="<?php echo $view->year; ?>">
									<button type="submit" class="btn btn-default">Previous Month</button>
								</form>
							</td>
							<td>
								<form class="form-inline" action="<?php echo $view->action_page; ?>" method="post" autocomplete="off">
									<input type="hidden" name="action" value="update_transaction">
									<input type="hidden" name="id" value="<?php echo $key; ?>">
									<input type="hidden" name="budget_month" value="next">
									<input type="hidden" name="budget_year" value="<?php echo $view->year; ?>">
									<button type="submit" class="btn btn-default">Next Month</button>
								</form>
							</td>
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