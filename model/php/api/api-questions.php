<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$questions = $dbh->getPostsQuestions($_GET["id"]);


header('Content-Type: application/json');
echo json_encode($questions);
?>