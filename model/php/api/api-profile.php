<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$result["logged"] = false;

if(isUserLoggedIn()){
    $result["logged"] = true;
    $result["idUser"] = $_SESSION["idUser"];
    $result["email"] = $_SESSION["email"];
}

header('Content-Type: application/json');
echo json_encode($result);
?>