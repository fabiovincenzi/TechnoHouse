<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$data[TAG_LOGGED] = false;

if(isUserLoggedIn()){
    $id = $_SESSION[TAG_USER_ID];
    $data[TAG_LOGGED] = true;
}
header('Content-Type: application/json');
echo json_encode($data);
?>