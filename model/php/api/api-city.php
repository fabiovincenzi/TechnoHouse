<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$cities = $dbh->getCitiesByProvince($_GET["province_id"]);


header('Content-Type: application/json');
echo json_encode($cities);
?>