<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$result["logged"] = false;
var_dump($_POST);

header('Content-Type: application/json');
echo json_encode($result);
?>