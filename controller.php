<?php 
require 'restaurant.php';

if (isset($_POST['restaurant_id'])) {
    if (isset($_POST['score'])) {
        $rest = Restaurant::find($_POST['restaurant_id']);
        $rest->rank($_POST['score']); 
        update($rest); 
    }
}

function update($rest) {
    $rest->update(); 
}
?>
