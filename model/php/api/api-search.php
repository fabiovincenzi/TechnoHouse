<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$result[TAG_LOGGED] = false;

if(isUserLoggedIn()){
    $result[TAG_LOGGED] = true;
    $id = $_SESSION[TAG_USER_ID];
    
    $tags = $dbh->getUserPreference($id);
    $posts = array();
    foreach($tags as $tag){
        array_push($posts, $dbh->getRandomPostsOf($tag, N_RANDOM_POSTS)[0]);
    }
    $result[TAG_SEARCH_POSTS] = $posts;
}
header('Content-Type: application/json');
echo json_encode($result);
?>