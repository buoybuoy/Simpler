<?php

	$view = new view;

?>
<div class="container">
	<div class="row">
		<div class="col-xs-7" id="transactionTable">
			<?php include('partials/_transaction_table_categorized.php'); ?>
		</div>
		<div class="col-xs-5" id="rightAside">
			<?php include('partials/_budget_info.php'); ?>
		</div>
	</div>
</div>

<?php include('partials/_transaction_modal.php'); ?>
<?php include('partials/_budget_modal.php'); ?>