<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
if(isset($_POST["latitude"]) && isset($_POST["longitude"]) && isset($_POST["postcode"])){
    $latitude = $_POST["latitude"];
    $latitude = $_POST["longitude"];
    $latitude = $_POST["postcode"];
    $building_id = $dbh->addBuilding($latitude, $longitude, $postcode)
    $user_id = 
    if(isset($_POST["title"]) && isset($_POST["description"]) && isset($_POST["price"])){
        $title = $_POST["title"];
        $description = $_POST["description"];
        $price = $_POST["price"];
        $dbh->createPost($title, $description, $price, $user_id, $building_id);    
    }
}
header('Content-Type: application/json');

?>