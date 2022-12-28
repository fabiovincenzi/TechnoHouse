<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$posts[TAG_LOGGED] = false;
if(isUserLoggedIn()){
    if ($_POST[TAG_ACTION] == SEND_POST_USER) {
        $posts[TAG_LOGGED] = true;
        $id = $_SESSION[TAG_USER_ID];
        $posts[TAG_USER_INFO] = $dbh->getUserByID($id);
        $posts[TAG_USER_INFO][TAG_USER_FOLLOWERS] = count($dbh->getFollowers($id));
        $posts[TAG_USER_INFO][TAG_USER_FOLLOWING] = count($dbh->getFollowing($id));
        $posts[TAG_USER_INFO][TAG_USER_SAVED] = count($dbh->getAllSaved($id));
        $users_posts = $dbh->getUsersPosts($id);
        $posts[TAG_USER_INFO][TAG_USER_NPHOTOS] = count($users_posts);
        $posts[TAG_USER_POST] = $users_posts;
    }
}
header('Content-Type: application/json');
echo json_encode($posts);
?>