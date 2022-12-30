<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$chats[TAG_LOGGED] = false;
if(isUserLoggedIn()){
    $chats[TAG_LOGGED] = true;
    $id = $_SESSION[TAG_USER_ID];
    $chats[TAG_USER_ID] = $id;
    $all_chat = $dbh->getAllChat($id);
    $chats[TAG_USER_ALL_CHAT] = array();
    foreach($all_chat as $chat){
        $ID_s = $chat[TAG_USER_CHAT_SOURCE];
        $ID_d = $chat[TAG_USER_CHAT_DESTINATION];
        $other = "";
        if($ID_s == $id && $ID_d != $id){
            $other = $dbh->getUserByID($ID_d)[0];
        }else if($ID_s != $id && $ID_d == $id){
            $other = $dbh->getUserByID($ID_s)[0];
        }
        array_push($chats[TAG_USER_ALL_CHAT], array(TAG_CHAT_ID => $chat[TAG_CHAT_ID],
         TAG_USER_NAME => $other[TAG_USER_NAME],
         TAG_USER_SURNAME => $other[TAG_USER_SURNAME],
         TAG_USER_IMAGE => getRelativeDirUser($other[TAG_USER_ID]).$other[TAG_USER_IMAGE]
        ));
    }
}
header('Content-Type: application/json');
echo json_encode($chats);
?>