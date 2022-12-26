<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$result["logged"] = false;

if(isset($_POST["email"]) && isset($_POST["password"])){
    $email = $_POST["email"];
    $password = $_POST["password"];
    $login_result = $dbh->checkLogin($email, $password);
    //var_dump($_SESSION);
    //var_dump($login_result);
    if (count($login_result) > 0) {
        registerLoggedUser(array("idUser"=>$login_result[0]["idUser"], "email"=>$email));
    } else {
        $result["errorMSG"] = "Error : The ".$dbh->getErrorString()." is not correct";
    }
    
}
if(isUserLoggedIn()){
    $result["logged"] = true;
}
header('Content-Type: application/json');
echo json_encode($result);

?>