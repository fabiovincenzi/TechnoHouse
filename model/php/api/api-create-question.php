<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';

if(isset($_POST["postId"]) && isset($_POST["question"])){
    $question = $_POST["question"];
    $postId = $_POST["postId"];
    $dbh->addQuestion($_SESSION[TAG_USER_ID], $postId, $question);
}else{
    echo json_encode("error");
}
header('Content-Type: application/json');

?>