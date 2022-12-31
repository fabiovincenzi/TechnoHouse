<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';

if(isset($_POST["tagName"])){
    $tag = $_POST["tagName"];
    $dbh->addTag($tag);
}else{
    echo json_encode("error");
}
header('Content-Type: application/json');

?>