<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$result[TAG_LOGGED] = false;

if(isUserLoggedIn()){
    $result[TAG_LOGGED] = true;
    $id = $_SESSION[TAG_USER_ID];
    if(!isset($_GET[TAG_USER_ID])){
        $result[TAG_USER_ID] = $id;
        $result[TAG_USER_EMAIL] = $_SESSION[TAG_USER_EMAIL];
    }else{
        $id_user = $_GET[TAG_USER_ID];
        $result[TAG_ME] = false;
        if ($id_user != $id) {
            $userInfos = $dbh->getUserByID($id_user)[0];
            $result[TAG_USER_INFO] = array(
            TAG_USER_ID => $userInfos[TAG_USER_ID],
            TAG_USER_NAME => $userInfos[TAG_USER_NAME],
            TAG_USER_SURNAME => $userInfos[TAG_USER_SURNAME],
            TAG_USER_IMAGE => $userInfos[TAG_USER_IMAGE],
            TAG_USER_FOLLOWERS => count($dbh->getFollowers($userInfos[TAG_USER_ID])),
            TAG_USER_FOLLOWING => count($dbh->getFollowing($userInfos[TAG_USER_ID])),
            TAG_USER_NPHOTOS => count($dbh->getPostById($id_user))
            );
        }else{
            $result[TAG_ME] = true;
        }
    }
}
header('Content-Type: application/json');
echo json_encode($result);
?>