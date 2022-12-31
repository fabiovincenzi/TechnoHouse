<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$data[TAG_LOGGED] = false;

if(isUserLoggedIn()){
    $id = $_SESSION[TAG_USER_ID];
    $data[TAG_LOGGED] = true;

    if (isset($_GET[TAG_USER_ID])) {
        $user_id = $_GET[TAG_USER_ID];
        $data[TAG_ME] = false;
        if ($user_id != $id) {
            if (!isset($_GET[TAG_ACTION])) {
                $data[TAG_FOLLOW] = $dbh->isFollowing($id, $user_id);
            } else if (isset($_GET[TAG_ACTION])) {
                if ($_GET[TAG_ACTION] == ACTION_FOLLOW){
                    $dbh->addFollowing($id, $user_id);
                    newFollowerNotification($dbh, $user_id, $id);
                }else if($_GET[TAG_ACTION] == ACTION_UNFOLLOW){
                    $dbh->removeFollowing($id, $user_id);
                }   
            }
        } else {
            $data[TAG_ME] = true;
        }        
    }
}
header('Content-Type: application/json');
echo json_encode($data);
?>