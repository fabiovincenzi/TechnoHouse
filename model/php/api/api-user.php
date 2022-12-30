<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$id = $_GET["id"];
$user = $dbh->getUserByID($id);

$user[0][TAG_USER_IMAGE] = getRelativeDirUser($id).$user[0][TAG_USER_IMAGE];

header('Content-Type: application/json');
echo json_encode($user);
?>