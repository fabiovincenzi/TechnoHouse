<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$provincies = $dbh->gerProvinciesByRegion($_GET["region_id"]);


header('Content-Type: application/json');
echo json_encode($provincies);
?>