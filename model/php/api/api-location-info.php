<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$location = $dbh->getLocationInfoFromPost($_GET["id"]);


header('Content-Type: application/json');
echo json_encode($location);
?>