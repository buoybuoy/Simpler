<div class="titlebar">
	<?php echo $view->link_relative_month($month, $year, -1); ?>
	<?php echo $view->link_relative_month($month, $year, 1); ?>
	<div class="container">
		<h3>
			<?echo $view->title($month, $year);?>
		</h3>
	</div>
</div>