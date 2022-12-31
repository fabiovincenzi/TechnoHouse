<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$data[TAG_LOGGED] = false;

if(isUserLoggedIn()){
    $data[TAG_LOGGED] = true;
    $id = $_SESSION[TAG_USER_ID];
    if(isset($_GET[TAG_CHAT_ID])){
        $idchat = $_GET[TAG_CHAT_ID];
        if($dbh->deleteMessages($idchat)){
            $dbh->deleteChat($idchat);
        }
    }
}
header('Content-Type: application/json');
echo json_encode($data);
?>