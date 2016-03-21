<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include('../include/config.class.php');
include('../include/data.class.php');
include('../include/database.class.php');

include('../include/auth.class.php');

$simple_url = 'https://bank.simple.com';

$transactions_url = $simple_url . '/transactions/data';
$login_url = $simple_url . '/signin';

function callAPI($url){
	$html_brand = $url;
	$ch = curl_init();
	$options = array(
	    CURLOPT_URL            => $html_brand,
	    CURLOPT_RETURNTRANSFER => true,
	    CURLOPT_HEADER         => true,
	    CURLOPT_FOLLOWLOCATION => true,
	    CURLOPT_ENCODING       => "",
	    CURLOPT_AUTOREFERER    => true,
	    CURLOPT_CONNECTTIMEOUT => 120,
	    CURLOPT_TIMEOUT        => 120,
	    CURLOPT_MAXREDIRS      => 10,
	);
	curl_setopt_array( $ch, $options );
	$response = curl_exec($ch); 
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	if ( $httpCode != 200 ){
	    echo "Return code is {$httpCode} \n"
	        .curl_error($ch);
	} else {
	    echo "<pre>".htmlspecialchars($response)."</pre>";
	}
	curl_close($ch);
}

//callAPI($transactions_url);

$username = $simpleAuth->username;
$password = $simpleAuth->password;
$loginUrl = $login_url;

//init curl
$ch = curl_init();

//Set the URL to work with
curl_setopt($ch, CURLOPT_URL, $loginUrl);

// ENABLE HTTP POST
curl_setopt($ch, CURLOPT_POST, 1);

//Set the post parameters
curl_setopt($ch, CURLOPT_POSTFIELDS, 'user='.$username.'&pass='.$password);

//Handle cookies for the login
curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');

//Setting CURLOPT_RETURNTRANSFER variable to 1 will force cURL
//not to print out the results of its query.
//Instead, it will return the results as a string return value
//from curl_exec() instead of the usual true/false.
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

//execute the request (the login)
$store = curl_exec($ch);

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if ( $httpCode != 200 ){
    echo "Return code is {$httpCode} \n";
    echo "<pre>".htmlspecialchars($store)."</pre>";
} else {
    echo "<pre>".htmlspecialchars($store)."</pre>";
}

//the login is now done and you can continue to get the
//protected content.

//set the URL to the protected file
curl_setopt($ch, CURLOPT_URL, $transactions_url);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, "");

//execute the request
$response = curl_exec($ch); 
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if ( $httpCode != 200 ){
    echo "Return code is {$httpCode} \n";
    echo "<pre>".htmlspecialchars($response)."</pre>";
} else {
    echo "<pre>".htmlspecialchars($response)."</pre>";
}

//save the data to disk
file_put_contents('temp.json', $response);