<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$posts = $dbh->getUsersFeed(1);

/*
for($i = 0; $i < count($posts); $i++){
    $posts[$i]["postimg"] = UPLOAD_DIR.$posts[$i]["postimg"];
}
*/
header('Content-Type: application/json');
echo json_encode($posts);
?>