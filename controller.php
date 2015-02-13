<?php 
require 'restaurant.php';
if (isset($_GET['tr'])) {
    index(); 
}

// Return the number of POIDS to be rendered
function index() {
    echo RestaurantInfo::$id;
}

?>
