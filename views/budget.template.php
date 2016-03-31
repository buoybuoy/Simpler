<?php

	$view = new view;

	include('partials/_dochead.php');
	include('partials/_nav.php');
	include('partials/_titlebar.php');
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
</div> <!-- #page -->

<?php
	include('partials/_transaction_modal.php');
	include('partials/_budget_modal.php');
	include('partials/_footer.php');
