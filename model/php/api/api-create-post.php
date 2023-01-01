<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';

if(isset($_POST["title"]) && isset($_POST["description"]) && isset($_POST["price"]) && isset($_POST["latitude"]) && isset($_POST["longitude"]) && isset($_POST["city_id"])&& isset($_POST["address"])){
    $title = $_POST["title"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $user_id = $_SESSION[TAG_USER_ID];
    date_default_timezone_set('Europe/Rome');
    $publish_time = date('Y-m-d H:i:s', time());
    $latitude = $_POST["latitude"];
    $longitude = $_POST["longitude"];
    $address = $_POST["address"];
    $city_id = $_POST["city_id"];
    echo json_encode($publish_time);
    $res = $dbh->addPost($title, $description, $price, $user_id, $publish_time, $latitude, $longitude, $address, $city_id);    
    newPostNotification($dbh, $user_id, $dbh->getLastUsersPosts($user_id)[0][TAG_POST_ID]);
}else{
    echo json_encode("error");
}
header('Content-Type: application/json');

?>