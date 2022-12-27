<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$regions = $dbh->getRegions();


header('Content-Type: application/json');
echo json_encode($regions);
?>