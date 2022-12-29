<?php
require_once 'bootstrap.php';
//$chats = $dbh->getChatsByUser($_SESSION["idUser"]);

header('Content-Type: application/json');
echo json_encode($chats);
?>