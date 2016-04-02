<?php

	$view = new view;
	$title = 'Upload';

	include('partials/_dochead.php');
	include('partials/_nav.php');
?>

<div class="titlebar">
	<div class="container">
		<h3>
			<?echo $title;?>
		</h3>
	</div>
</div>

<div class="container">

	<!-- <form action="/simpler/upload/index.php" class="dropzone" id="my-awesome-dropzone"></form> -->
	<form action="<?php echo $action_page; ?>" class="form" method="post" enctype="multipart/form-data">
		<input type="file" name="file" id="file">
	    <input type="submit" value="Upload" name="submit">
	</form>

</div>

<!-- <script src="js/plugins/dropzone/dropzone.js"></script> -->
<?php
	include('partials/_footer.php');