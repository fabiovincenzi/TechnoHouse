<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$images = $dbh->getPostImages($_GET["id"]);


header('Content-Type: application/json');
echo json_encode($images);
?>