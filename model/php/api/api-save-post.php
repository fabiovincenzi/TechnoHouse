<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$postId = $_GET["postId"];
$userId = $_SESSION[TAG_USER_ID];
$dbh->savePost($postId, $userId);
$targetUser = $dbh->getUserByPost($postId)[0];
newSaveNotification($dbh, $targetUser[TAG_USER_ID], $userId, $postId);

header('Content-Type: application/json');
?>