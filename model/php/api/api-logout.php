<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$result[TAG_RESULT] = false;

if(isUserLoggedIn()){
    session_destroy();
    $result[TAG_RESULT] = true;
}
header('Content-Type: application/json');
echo json_encode($result);

?>