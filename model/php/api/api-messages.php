<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$messages = $dbh->getMessagesByChat($_SESSION["idChat"]);

header('Content-Type: application/json');
echo json_encode($messages);
?>