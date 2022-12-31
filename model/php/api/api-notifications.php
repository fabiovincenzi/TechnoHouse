<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$notifications = $dbh->getNotifications($_SESSION[TAG_USER_ID]);

header('Content-Type: application/json');
echo json_encode($notifications);
?>