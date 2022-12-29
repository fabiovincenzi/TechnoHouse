<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';

if(isset($_POST["lastPostId"]) && isset($_POST["tags"])){
    $tags = $_POST["tags"];
    $lastPost = $_POST["lastPostId"];
    for ($i = 0; $i < count($tags); $i++) {  
        $dbh->addTagToPost($tags[$i], $lastPost);    
    }

}else{
    echo json_encode("error");
}
header('Content-Type: application/json');

?>