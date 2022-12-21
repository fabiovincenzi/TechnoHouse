<?php
require_once 'bootstrap.php';

$result["logged"] = false;

if(isset($_POST["email"]) && isset($_POST["password"])){
    $login_result = $dbh->checkLogin($_POST["email"], $_POST["password"]);
    if(count($login_result)==0){
        //Login fallito
        $result["loginError"] = "Username e/o password errati";
    }
    else{
        registerLoggedUser($login_result[0]);
    }
}

if(isUserLoggedIn()){
    $result["logged"] = true;
    $result["userFeed"] = $dbh->getFeedByUser($_SESSION["idUser"]);
    
}

header('Content-Type: application/json');
echo json_encode($result);

?>