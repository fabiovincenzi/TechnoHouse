<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';

if(isset($_POST["questionId"]) && isset($_POST["answer"])){
    $questionId = $_POST["questionId"];
    $answer = $_POST["answer"];
    $dbh->addAnswer($_SESSION[TAG_USER_ID], $questionId, $answer);
    $post = $dbh->getPostByQuestion($questionId)[0];
    $targetUser = $dbh->getUserByPost($post[TAG_POST_ID])[0];
    newAnswerNotification($dbh, $targetUser[TAG_USER_ID], $_SESSION[TAG_USER_ID], $post[TAG_POST_ID]);
}else{
    echo json_encode("error");
}
header('Content-Type: application/json');

?>