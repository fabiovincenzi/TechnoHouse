<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/util/functions.php';
$result["logged"] = false;

if(isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["residence"]) && isset($_POST["birthdate"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm-password"])){
    var_dump($_POST);
}
header('Content-Type: application/json');
echo json_encode($result);
?>