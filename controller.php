<?php 
require 'restaurant.php';

// Connects to the database
function connect_to_database() {
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

    return $conn; 
}

// If the post has restaurant_id, then is an update
if (isset($_POST['restaurant_id'])) {
    if (isset($_POST['score'])) {
        connect_to_database(); 

        $rest = Restaurant::find($_POST['restaurant_id']);
        $rest->rank($_POST['score']); 
        update($rest); 

        mysql_close(); 
    }
}

function update($rest) {
    $rest->update(); 
}
