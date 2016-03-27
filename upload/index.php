<?php

include('../include/database.class.php');
include('../include/upload.class.php');


// var_dump($_POST);
 
if (!empty($_FILES)) {

	$upload = new upload($_FILES);

	// var_dump($_FILES);
     

     
}
header('Location:' . $config->base_url);

?>