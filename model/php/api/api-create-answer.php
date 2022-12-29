<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';

if(isset($_POST["questionId"]) && isset($_POST["answer"])){
    $questionId = $_POST["questionId"];
    $answer = $_POST["answer"];
    $dbh->addAnswer($_SESSION[TAG_USER_ID], $questionId, $answer);
}else{
    echo json_encode("error");
}
header('Content-Type: application/json');

?>