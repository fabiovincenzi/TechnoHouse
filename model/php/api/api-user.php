<?php
require_once 'bootstrap.php';
$users = $dbh->getUsers(2);


header('Content-Type: application/json');
echo json_encode($users);
?>