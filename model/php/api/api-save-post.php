<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$posts[TAG_LOGGED] = false;
if(isUserLoggedIn()){
    if (isset($_GET[TAG_ACTION])&& isset($_GET["postId"])) {
        $postId = $_GET["postId"];
        $userId = $_SESSION[TAG_USER_ID];
        if ($_GET[TAG_ACTION] == 1) {
            $dbh->savePost($postId, $userId);
            $targetUser = $dbh->getUserByPost($postId)[0];
            newSaveNotification($dbh, $targetUser[TAG_USER_ID], $userId, $postId);
        }else if ($_GET[TAG_ACTION] == 2){
            $dbh->removeFromSaved($postId, $userId);
        }
    }
}

header('Content-Type: application/json');
?>