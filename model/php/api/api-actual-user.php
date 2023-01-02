<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$data[TAG_LOGGED] = false;

if(isUserLoggedIn()){
    $data[TAG_LOGGED] = true;
    $id = $_SESSION[TAG_USER_ID];
    $user = $dbh->getUserByID($id);
    $data[TAG_USER] = $user;
}
header('Content-Type: application/json');
echo json_encode($data);
?>