<div class="modal fade" id="transactionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
				<h4 class="modal-title">Edit Transaction </h4>
			</div>
			<form data-modal="#transactionModal" action="<?php echo $this->action_page; ?>" method="post" autocomplete="off" class="form ajax-form" id="transactionForm">
				<input type="hidden" name="action" value="update_transaction">
				<input type="hidden" name="id" id="transactionId" value="placeholder">
				<input type="hidden" name="budget_year" value="<?php echo $this->year; ?>">
				<div class="modal-body">
					<table class="table">
						<tbody>
							<tr>
								<td id="date">Placeholder</td>
								<td class="description">Placeholder</td>
								<td id="amount" class="align-right">0</td>
							</tr>
						</tbody>
					</table>
					
					<h4 class="margin-top">Spend From</h4>

					<div class="row">
						<div class="col-xs-5">
							<fieldset class="form-group">
								<select class="form-control" id="budget_categories" name="budget_category_id">
									<?php foreach($this->budgeted_amounts as $id => $budgeted_amount) {
										echo '<option value="' . $id . '">' . $budgeted_amount['category_name'] . '</option>';
									} ?>
								</select>
							</fieldset>
						</div>
						<div class="col-xs-7">
							<div class="btn-group" data-toggle="buttons">
								<label class="btn btn-default">
									<input type="radio" name="budget_month" id="inlineRadio2" value="prev"> Last Month
								</label>
								<label class="btn btn-default active">
									<input type="radio" name="budget_month" id="inlineRadio1" value="<?php echo $this->month; ?>" checked> This Month
								</label>
								<label class="btn btn-default">
									<input type="radio" name="budget_month" id="inlineRadio3" value="next"> Next Month
								</label>
							</div>
						</div>
					</div>
					
					<div class="row margin-top">
						<div class="col-xs-12">
							<div class="input-group">
								<input class="checkbox" type="checkbox" aria-label="..." name="create_trigger" value="true" id="alwaysCategorize">
								Always categorize
								<select class="form-control inline-form-element" id="select_trigger" name="trigger_type">
									<option value="description" class="description" selected>Placeholder</option>
									<option value="raw_description" id="raw_description">Placeholder</option>
									<option value="category" id="category">Placeholder</option>
									<option value="category_type" id="category_type">Placeholder</option>
								</select>
								This way
							</div>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary submit" data-toggle="modal" data-target="#transactionModal">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>