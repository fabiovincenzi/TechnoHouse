<?php
require_once 'bootstrap.php';

$result["false"] = logineseguito;

if(isset($_POST["username"]) && isset($_POST["password"])){
    $login_result = $dbh->checkLogin($_POST["username"], $_POST["password"]);
    if(count($login_result)==0){
        //Login fallito
        $result["errorelogin"] = "Username e/o password errati";
    }
    else{
        registerLoggedUser($login_result[0]);
    }
}

if(isUserLoggedIn()){
    $result["logineseguito"] = true;
    $result["feeduser"] = $dbh->getFeedByUser($_SESSION["iduser"]);
    
}

header('Content-Type: application/json');
echo json_encode($result);





?>