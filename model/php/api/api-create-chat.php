<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$data[TAG_LOGGED] = false;

if(isUserLoggedIn()){
    $data[TAG_LOGGED] = true;
    $id = $_SESSION[TAG_USER_ID];
    if(isset($_GET[TAG_USER_ID])){
        $id_user = $_GET[TAG_USER_ID];
        $dbh->addChat($id, $id_user);
        $data[TAG_CHAT_ID] = $dbh->getChatByUsers($id, $id_user)[0][TAG_CHAT_ID];
    }
}
header('Content-Type: application/json');
echo json_encode($data);
?>