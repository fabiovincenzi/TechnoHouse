<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';


$result[TAG_LOGGED] = false;
if(isUserLoggedIn()){
    $result[TAG_LOGGED] = true;
    $result[TAG_ME] = false;
    if(isset($_GET[TAG_USER_ID])){
        $id_user = $_SESSION[TAG_USER_ID];
        $other_user = $_GET[TAG_USER_ID];
        if(strval($id_user) == ($other_user)){
            $result[TAG_ME] = true;
            $userInfos = $dbh->getUserByID($id_user)[0];
            $result[TAG_USER_INFO] = array(
                TAG_USER_ID => $userInfos[TAG_USER_ID],
                TAG_USER_NAME => $userInfos[TAG_USER_NAME],
                TAG_USER_SURNAME => $userInfos[TAG_USER_SURNAME],
                TAG_USER_PHONE => $userInfos[TAG_USER_PHONE],
                TAG_USER_BIRTHDATE => $userInfos[TAG_USER_BIRTHDATE],
                TAG_USER_EMAIL => $userInfos[TAG_USER_EMAIL],
                TAG_USER_IMAGE => (getRelativeDirUser($userInfos[TAG_USER_ID]).$userInfos[TAG_USER_IMAGE])
                );
        }
    }
}
header('Content-Type: application/json');
echo json_encode($result);
?>