<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$chats[TAG_LOGGED] = false;
if(isUserLoggedIn()){
    $chats[TAG_LOGGED] = true;
    $id = $_SESSION[TAG_USER_ID];

    if(isset($_GET[TAG_CHAT_ID])){
        $idChat = $_GET[TAG_CHAT_ID];

        if(!isset($_POST[TAG_CHAT_BODY])){
            $chats[TAG_USER_SINGLE_CHAT] = array();
            $messages = $dbh->getChatMessages($idChat);
            foreach($messages as $message){
                $sender = $message[TAG_USER_ID];
                $body = $message[TAG_CHAT_BODY];
                $date = $message[TAG_CHAT_DATE];
                array_push($chats[TAG_USER_SINGLE_CHAT], array(
                TAG_ME => $id == $send,
                TAG_USER_NAME => $send[TAG_USER_NAME],
                TAG_USER_SURNAME => $send[TAG_USER_SURNAME],
                TAG_CHAT_BODY => $body,
                TAG_CHAT_DATE => $date
                ));
            }
        }
    }else if(isset($_POST[TAG_CHAT_BODY]) && isset($_POST[TAG_CHAT_ID])){
        date_default_timezone_set('Europe/Rome');
        $publish_time = date('Y-m-d H:i:s', time());
        $message = $_POST[TAG_CHAT_BODY];
        $chat_id = $_POST[TAG_CHAT_ID];
        $dbh->addMessage($message, $publish_time, $id, $chat_id);
    }
}
//$chats = $dbh->getChatsByUser($_SESSION["idUser"]);
header('Content-Type: application/json');
echo json_encode($chats);
?>