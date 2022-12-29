<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$chats[TAG_LOGGED] = false;
if(isUserLoggedIn()){
    $chats[TAG_LOGGED] = true;
    if(isset($_GET[TAG_USER_ID])){
        $user_id = $_GET[TAG_USER_ID];
        
    }
}
//$chats = $dbh->getChatsByUser($_SESSION["idUser"]);
header('Content-Type: application/json');
echo json_encode($chats);
?>