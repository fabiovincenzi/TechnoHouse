<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$tags = $dbh->getTagsByPost($_GET["id"]);

header('Content-Type: application/json');
echo json_encode($tags);
?>