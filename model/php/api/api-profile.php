<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$result[TAG_LOGGED] = false;

if(isUserLoggedIn()){
    $result[TAG_LOGGED] = true;
    $result[TAG_USER_ID] = $_SESSION[TAG_USER_ID];
    $result[TAG_USER_EMAIL] = $_SESSION[TAG_USER_EMAIL];
}

header('Content-Type: application/json');
echo json_encode($result);
?>