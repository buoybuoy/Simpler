<?php

include('../include/config.class.php');
include('../include/database.class.php');
include('../include/upload.class.php');

$filename = 'test_3-20-16.json';
$file = $config->root_dir . 'upload/data/' . $filename;
$string = file_get_contents($file);
$raw_simple_data = json_decode($string, true);

$upload->handle($raw_simple_data);


header('Location:' . $config->base_url);

?>