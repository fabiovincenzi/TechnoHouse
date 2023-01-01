<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$chats[TAG_LOGGED] = false;
if(isUserLoggedIn()){
    $chats[TAG_LOGGED] = true;
    $id = $_SESSION[TAG_USER_ID];

    if(isset($_GET[TAG_CHAT_ID])){
        $idChat = $_GET[TAG_CHAT_ID];
        $chats[TAG_TOTAL_MESSAGES] = count($dbh->getChatMessages($idChat));
    }
}
//$chats = $dbh->getChatsByUser($_SESSION["idUser"]);
header('Content-Type: application/json');
echo json_encode($chats);
?>