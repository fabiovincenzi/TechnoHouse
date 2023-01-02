<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$result[TAG_LOGGED] = false;

if(isUserLoggedIn()){
    $result[TAG_LOGGED] = true;
    $id = $_SESSION[TAG_USER_ID];
    
    $tags = $dbh->getUserPreference($id);
    $posts = array();
    if (count($tags) > 0) {
        $ids=array();
        foreach ($tags as $tag) {
            //["path"] = getRelativeDirUserPost($post[0]["User_idUser"], $idPost).$images[$i]["path"];
            $post_tags = $dbh->getRandomPostsOf($tag["Tag_idTag"], N_RANDOM_POSTS, $id);
            foreach ($post_tags as $post) {
                if (!in_array($post[TAG_POST_ID], $ids)) {
                    $image = $dbh->getPostImages($post[TAG_POST_ID]);
                    if (count($image) > 0) {
                        $image = $image[0];
                        $post[TAG_POST_PATH] = getRelativeDirUserPost($post[TAG_POST_USER], $post[TAG_POST_ID]) . $image[TAG_POST_PATH];
                        array_push($ids, $post[TAG_POST_ID]);
                        array_push($posts, $post);
                    }
                }
            }
        }
    }else{
        $random_posts = $dbh->getRandomPosts(N_RANDOM_POSTS, $id);
        foreach ($random_posts as $post) {
            $image = $dbh->getPostImages($post[TAG_POST_ID]);
            if (count($image) > 0) {
                $image = $image[0];
                $post[TAG_POST_PATH] =  getRelativeDirUserPost($post[TAG_POST_USER], $post[TAG_POST_ID]) . $image[TAG_POST_PATH];
                array_push($posts, $post);
            }
        }
    }
    $result[TAG_SEARCH_POSTS] = $posts;
}
header('Content-Type: application/json');
echo json_encode($result);
?>