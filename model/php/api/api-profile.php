<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$result[TAG_LOGGED] = false;

if(isUserLoggedIn()){
    if(!isset($_GET[TAG_USER_ID])){
        $result[TAG_LOGGED] = true;
        $result[TAG_USER_ID] = $_SESSION[TAG_USER_ID];
        $result[TAG_USER_EMAIL] = $_SESSION[TAG_USER_EMAIL];
    }else{
        $id_user = $_GET[TAG_USER_ID];
        $userInfos = $dbh->getUserByID($id_user)[0];
        $result[TAG_USER_INFO] = array(
        TAG_USER_ID => $userInfos[TAG_USER_ID],
        TAG_USER_NAME => $userInfos[TAG_USER_NAME],
        TAG_USER_SURNAME => $userInfos[TAG_USER_SURNAME],
        TAG_USER_FOLLOWERS => count($dbh->getFollowers($userInfos[TAG_USER_ID])),
        TAG_USER_FOLLOWING => count($dbh->getFollowing($userInfos[TAG_USER_ID])));
    }
}
header('Content-Type: application/json');
echo json_encode($result);
?>