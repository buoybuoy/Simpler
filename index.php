<?php

include('include/config.class.php');
include('include/database.class.php');
include('include/controller.class.php');
include('include/view.class.php');

include('template/partials/_dochead.php');
include('template/partials/_nav.php');
include('template/partials/_titlebar.php');


?>

<div class="container">
	<div class="row">
		<div class="col-xs-7">
			<?php include('template/partials/_transaction_table.php'); ?>
		</div>
		<div class="col-xs-5 right-aside">
			<?php include('template/partials/_rightaside.php'); ?>
		</div>
	</div>
</div>

<?php include('template/partials/_modal.php'); ?>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/app.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>