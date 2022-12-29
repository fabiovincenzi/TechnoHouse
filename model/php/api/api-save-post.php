<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$dbh->savePost($_GET["postId"], $_SESSION[TAG_USER_ID]);

header('Content-Type: application/json');
?>