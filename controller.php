<?php 
require 'restaurant.php';
// Gets the number of pois to render
if (isset($_GET['tr'])) {
    session_start();
    echo var_dump($_SESSION['n_poi']);
}
?>
