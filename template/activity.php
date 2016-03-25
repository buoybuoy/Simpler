<?php
	$this->load_partial('dochead');
	$this->load_partial('nav');
	$this->load_partial('titlebar');
?>

<div class="container">
	<div class="row">
		<div class="col-xs-7">
			<?php $this->load_partial('transaction_table'); ?>
		</div>
		<div class="col-xs-5 right-aside">
			<?php $this->load_partial('activity_totals'); ?>
		</div>
	</div>
</div>

<?php
	$this->load_partial('transaction_modal');
	$this->load_partial('budget_modal');
	$this->load_partial('footer');