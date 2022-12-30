<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$idPost = $_GET["id"];
$post = $dbh->getPostById($idPost);
$images = $dbh->getPostImages($idPost);

for($i = 0; $i < count($images); $i++){
    $images[$i]["path"] = getRelativeDirUserPost($post[0]["User_idUser"], $idPost).$images[$i]["path"];
}
header('Content-Type: application/json');
echo json_encode($images);
?>