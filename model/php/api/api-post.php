<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$posts[TAG_LOGGED] = false;
if(isUserLoggedIn()){
    $id = $_SESSION[TAG_USER_ID];
    $posts[TAG_LOGGED] = true;
    if (isset($_GET[TAG_ACTION])) {
        if ($_GET[TAG_ACTION] == SEND_POST_USER) {
            $posts[TAG_USER_INFO] = $dbh->getUserByID($id);
            $posts[TAG_USER_INFO][0][TAG_USER_IMAGE] = getRelativeDirUser($id).$posts[TAG_USER_INFO][0][TAG_USER_IMAGE];
            $posts[TAG_USER_INFO][TAG_USER_FOLLOWERS] = count($dbh->getFollowers($id));
            $posts[TAG_USER_INFO][TAG_USER_FOLLOWING] = count($dbh->getFollowing($id));
            $posts[TAG_USER_INFO][TAG_USER_SAVED] = count($dbh->getAllSaved($id));
            $users_posts = $dbh->getUsersPosts($id);
            $posts[TAG_USER_INFO][TAG_USER_NPHOTOS] = count($users_posts);
            $posts[TAG_USER_POST] = $users_posts;
        } else if ($_GET[TAG_ACTION] == GET_USER_FEED) {
            $posts = $dbh->getUsersFeed($id);
        } else if ($_GET[TAG_ACTION] == GET_POST_BY_ID){
            if(isset($_GET[POST_ID]))
            $posts = $dbh->getPostById()
        }
    }else if(isset($_GET[TAG_USER_ID])){
        $user_id = $_GET[TAG_USER_ID];
        $posts[TAG_ME] = false;
        if($user_id != $id){
            $users_posts = $dbh->getUsersPosts($user_id);
            $posts[TAG_USER_POST] = $users_posts;
        }else{
            $posts[TAG_ME] = true;
        }
    }
}
header('Content-Type: application/json');
echo json_encode($posts);
?>