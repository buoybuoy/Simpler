<?php
	$this->load_partial('dochead', false);
	$this->load_partial('nav', false);
	$this->load_partial('titlebar', false);
?>

<div class="container">
	<div class="row">
		<div class="col-xs-7" id="transactionTable">
			<?php $this->load_partial('transaction_table_categorized', true); ?>
		</div>
		<div class="col-xs-5" id="rightAside">
			<?php $this->load_partial('budget_info', true); ?>
		</div>
	</div>
</div>

<?php
	$this->load_partial('transaction_modal', true);
	$this->load_partial('budget_modal', true);
	$this->load_partial('footer', false);