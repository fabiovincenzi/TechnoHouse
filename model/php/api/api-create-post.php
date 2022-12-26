<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';

if(isset($_POST["title"]) && isset($_POST["description"]) && isset($_POST["price"]) && isset($_POST["location"])){
    $title = $_POST["title"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $location = $_POST["location"];
    $dbh->createPost();
    $login_result = $dbh->checkLogin($email, $password);
    //var_dump($_SESSION);
    //var_dump($login_result);
    if (count($login_result) > 0) {
        registerLoggedUser(array("idUser"=>$login_result[0]["idUser"], "email"=>$email));
    } else {
        $result["errorMSG"] = "Error : The ".$dbh->getErrorString()." is not correct";
    }
    
}
if(isUserLoggedIn()){
    $result["logged"] = true;
}
header('Content-Type: application/json');
echo json_encode($result);

?>