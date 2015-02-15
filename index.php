<?php
require 'restaurant.php';
require_once './ARELLibrary/arel_xmlhelper.class.php';

// Some variables
$server = '127.0.0.1';
$username = 'juan';
$password = 'bigmac5!';
$db_name = 'RA';

// Connect to mysql database
$conn = mysql_connect($server, $username, $password); 
// Check mysql connection
if (!$conn) {
    die("Connection failed: " . mysql_error()); 
}
// Selecting a database
$db = mysql_select_db($db_name, $conn); 
// Checking selection
if (!$db) {
    die("Could not select database: " . mysql_error()); 
}


// Calls the database and retrieves all the restaurants in it
$restaurants = Restaurant::all(); 

RestaurantInfo::startRendering(); 

foreach($restaurants as $res) {

    $restInfo = new RestaurantInfo($res); 
    $restInfo->render(); 
}

$_SESSION['n_poi'] = RestaurantInfo::$id; 

RestaurantInfo::stopRendering(); 
mysql_close(); 

?>
