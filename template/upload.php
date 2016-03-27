<?php

	$this->load_partial('dochead', false);
	$this->load_partial('nav', false);
	$this->load_partial('titlebar', false);
?>

<div class="container">

	<!-- <form action="/simpler/upload/index.php" class="dropzone" id="my-awesome-dropzone"></form> -->
	<form action="/simpler/upload/index.php" class="form" method="post" enctype="multipart/form-data">
		<input type="file" name="file" id="file">
	    <input type="submit" value="Upload" name="submit">
	</form>

</div>

<!-- <script src="js/plugins/dropzone/dropzone.js"></script> -->
<?php
	$this->load_partial('footer', false);