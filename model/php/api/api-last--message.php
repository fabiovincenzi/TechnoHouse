<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$chats[TAG_LOGGED] = false;
if(isUserLoggedIn()){
    $chats[TAG_LOGGED] = true;
    $id = $_SESSION[TAG_USER_ID];
    $chats[TAG_USER_ID] = $id;
    $last_message = $dbh->getLastIndex(MESSAGE_TABLE)[0];
    $chats[TAG_LAST_MESSAGE] = $last_message;
}
header('Content-Type: application/json');
echo json_encode($chats);
?>