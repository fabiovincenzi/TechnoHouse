<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$chats[TAG_LOGGED] = false;
if(isUserLoggedIn()){
    $chats[TAG_LOGGED] = true;
    $id = $_SESSION[TAG_USER_ID];

    if(isset($_GET[TAG_CHAT_ID])){
        $idChat = $_GET[TAG_CHAT_ID];
        $chat = $dbh->getChatById($idChat)[0];
        $destination= $chat[TAG_USER_CHAT_SOURCE] == $id ? $dbh->getUserByID($chat[TAG_USER_CHAT_DESTINATION])[0] : $dbh->getUserByID($chat[TAG_USER_CHAT_SOURCE])[0];
        
        $chats[TAG_DESTINATION] = array(TAG_USER_ID => $destination[TAG_USER_ID], 
        TAG_USER_NAME => $destination[TAG_USER_NAME],
        TAG_USER_SURNAME => $destination[TAG_USER_SURNAME], 
        TAG_USER_IMAGE => getRelativeDirUser($destination[TAG_USER_ID]).$destination[TAG_USER_IMAGE]);
        
        //This is the logged user, infos about the logged user
        $source = $dbh->getUserById($id)[0];
        $chats[TAG_SOURCE] = array(TAG_USER_ID => $source[TAG_USER_ID], 
        TAG_USER_NAME => $source[TAG_USER_NAME],
        TAG_USER_SURNAME => $source[TAG_USER_SURNAME], 
        TAG_USER_IMAGE => getRelativeDirUser($source[TAG_USER_ID]).$source[TAG_USER_IMAGE]);

        if(!isset($_POST[TAG_CHAT_BODY])){
            $chats[TAG_USER_SINGLE_CHAT] = array();
            $messages = $dbh->getChatMessages($idChat);
            $chats[TAG_TOTAL_MESSAGES] = count($messages);
            if(count($messages) > 0){
                foreach($messages as $message){
                    $sender_info = $dbh->getUserByID($message[TAG_USER_CHAT_SOURCE])[0];
                    $sender = $message[TAG_USER_CHAT_SOURCE];
                    $body = $message[TAG_CHAT_BODY];
                    $date = $message[TAG_CHAT_DATE];
                    array_push($chats[TAG_USER_SINGLE_CHAT], array(
                    TAG_ME => $id == $sender,
                    TAG_USER_NAME => $sender_info[TAG_USER_NAME],
                    TAG_USER_SURNAME => $sender_info[TAG_USER_SURNAME],
                    TAG_CHAT_BODY => $body,
                    TAG_CHAT_DATE => $date,
                    TAG_USER_IMAGE => getRelativeDirUser($sender_info[TAG_USER_ID]).$sender_info[TAG_USER_IMAGE]
                    ));
                }
            }
        }
    }else if(isset($_POST[TAG_CHAT_BODY]) && isset($_POST[TAG_CHAT_ID])){
        date_default_timezone_set('Europe/Rome');
        $publish_time = date('Y-m-d H:i:s', time());
        $user = $dbh->getUserByID($id)[0];
        $message = $_POST[TAG_CHAT_BODY];
        $chat_id = $_POST[TAG_CHAT_ID];
        if ($message != "") {
            $chat = $dbh->getChatById($chat_id)[0];
            $destination= $chat[TAG_USER_CHAT_SOURCE] == $id ? $dbh->getUserByID($chat[TAG_USER_CHAT_DESTINATION])[0] : $dbh->getUserByID($chat[TAG_USER_CHAT_SOURCE])[0];
            $destination_email = $destination[TAG_USER_EMAIL];
            $message_mail = $user[TAG_USER_NAME] . " " . $user[TAG_USER_SURNAME] . " sent a new message : ".$message;
            sendEmail(MAIL_SOURCE, $destination_email, MESSAGE_SUBJECT, $message_mail);
            $dbh->addMessage($message, $publish_time, $id, $chat_id);
            newMessageNotification($dbh, $chat);
        }
    }
}
//$chats = $dbh->getChatsByUser($_SESSION["idUser"]);
header('Content-Type: application/json');
echo json_encode($chats);
?>