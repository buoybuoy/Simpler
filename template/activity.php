<?php
	$this->load_partial('dochead', false);
	$this->load_partial('nav', false);
	$this->load_partial('titlebar', false);
?>

<div class="container">
	<div class="row">
		<div class="col-xs-7">
			<?php $this->load_partial('transaction_table', true); ?>
		</div>
		<div class="col-xs-5 right-aside">
			<?php $this->load_partial('activity_totals', true); ?>
		</div>
	</div>
</div>

<?php
	$this->load_partial('transaction_modal', false);
	$this->load_partial('budget_modal', false);
	$this->load_partial('footer', false);