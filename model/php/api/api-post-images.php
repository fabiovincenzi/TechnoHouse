<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$images = $dbh->getPostImages($_GET["id"]);

for($i = 0; $i < count($images); $i++){
    $images[$i]["path"] = UPLOAD_DIR.$images[$i]["path"];
}

header('Content-Type: application/json');
echo json_encode($images);
?>