<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$post = $dbh->getLastUsersPosts($_SESSION[TAG_USER_ID]);

header('Content-Type: application/json');
echo json_encode($post);
?>