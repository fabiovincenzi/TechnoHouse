<?php
require_once 'bootstrap.php';
$posts = $dbh->getPosts(2);

/*
for($i = 0; $i < count($posts); $i++){
    $posts[$i]["postimg"] = UPLOAD_DIR.$posts[$i]["postimg"];
}
*/
header('Content-Type: application/json');
echo json_encode($posts);
?>