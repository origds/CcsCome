<?php
require 'restaurant.php';
require_once './ARELLibrary/arel_xmlhelper.class.php';

// Connect to mysql database
$conn = mysql_connect(SERVER, USERNAME, PASSWORD); 
// Check mysql connection
if (!$conn) {
    die("Connection failed: " . mysql_error()); 
}
// Selecting a database
$db = mysql_select_db(DB_NAME, $conn); 
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

RestaurantInfo::stopRendering(); 

var_dump($_ENV); 
mysql_close(); 

?>
