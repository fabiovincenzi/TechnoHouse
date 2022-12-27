<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$data[TAG_LOGGED] = false;

if(isUserLoggedIn()){
    $data[TAG_LOGGED] = true;
    $data[TAG_USER_FOLLOWERS] = $dbh->getFollowers($_SESSION[TAG_USER_ID]);
}
header('Content-Type: application/json');
echo json_encode($data);
?>