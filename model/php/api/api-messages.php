<?php
require_once 'bootstrap.php';
$messages = $dbh->getMessagesByChat($_SESSION["idChat"]);

header('Content-Type: application/json');
echo json_encode($messages);
?>