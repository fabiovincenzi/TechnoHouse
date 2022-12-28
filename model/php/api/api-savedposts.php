<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$data[TAG_LOGGED] = false;

if(isUserLoggedIn()){
    $data[TAG_LOGGED] = true;
    $id = $_SESSION[TAG_USER_ID];
    $saved_posts = $dbh->getAllSaved($id)[0];
    $data[TAG_USER_SAVED] = array();
    foreach($saved_posts as $row){
        $post = $dbh->getPostById($row(TAG_GET_POST));
        array_push($data[TAG_USER_SAVED], array(TAG_POST_ID => $post[TAG_POST_ID], 
                                                TAG_POST_TITLE => $post[TAG_POST_TITLE],
                                                ));
    }
}
header('Content-Type: application/json');
echo json_encode($data);
?>