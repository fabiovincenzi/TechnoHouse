<?php
require_once 'bootstrap.php';
$posts = $dbh->getProfilePosts($_SESSION["idUser"]);

header('Content-Type: application/json');
echo json_encode($posts);
?>