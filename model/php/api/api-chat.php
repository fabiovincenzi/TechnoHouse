<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$chats[TAG_LOGGED] = false;
if(isUserLoggedIn()){
    $chats[TAG_LOGGED] = true;

}
//$chats = $dbh->getChatsByUser($_SESSION["idUser"]);
header('Content-Type: application/json');
echo json_encode($chats);
?>