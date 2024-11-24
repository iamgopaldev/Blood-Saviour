<?php
// Error Reporting Turn On
ini_set('error_reporting', E_ALL);

// Setting up the time zone
date_default_timezone_set('Asia/Kolkata');
// Host Name
// $dbhost = 'us-cdbr-east-03.cleardb.com';

// // Database Name
// $dbname = 'heroku_3f3a86148259202';

// // Database Username
// $dbuser = 'b4dc38a7c88538';

// // Database Password
// $dbpass = 'c11aea67';

// // Defining base url
// define("BASE_URL", "https://glacial-tor-64646.herokuapp.com/");
$dbhost = 'localhost';

// Database Name
$dbname = 'Blood_Saviour';

// Database Username
$dbuser = 'root';

// Database Password
$dbpass = '';

// Defining base url
define("BASE_URL", "http://localhost/cms/");

// Getting Admin url
define("ADMIN_URL", BASE_URL . "admin" . "/");

try {
	$pdo = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpass);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch( PDOException $exception ) {
	echo "Connection error :" . $exception->getMessage();
}
